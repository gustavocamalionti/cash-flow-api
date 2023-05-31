<?php

namespace App\Services;

use Exception;
use Throwable;
use Illuminate\Bus\Batch;
use App\Jobs\TransactionJob;
use App\Jobs\SendEmailToPayerJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmailToReceivedJob;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\TransactionRepository;

class TransactionService extends BaseService
{
    protected $modelRepository;
    protected $userRepository;
    protected $data;
    public function __construct(
        TransactionRepository $modelRepository,
        UserRepository $userRepository
    ) {
        $this->modelRepository = $modelRepository;
        $this->userRepository = $userRepository;
    }

    public function verifyDocumentType($idEspecific)
    {
        $user = $this->userRepository->findById($idEspecific);
        if ($user == null or $user == "") {
            return null;
        }

        if (strlen($user->document) == 14) {
            return 'cnpj';
        } 

        return 'cpf';
        
    }

    public function getBalanceInAccount($idEspecific)
    {
        $user = $this->userRepository->findById($idEspecific);
        if ($user == null or $user == "") {
            return 0;
        }
        return $user->balance;
    }

    public function getAuthorization()
    {
        $response = Http::accept('application/json')->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->json();

        if ($response['message'] == 'Autorizado') {
            return true;
        } 

        return false;
    }



    public function addTransactionJobToQueue($data)
    {
        $this->data = $data;
        $transactionAuth= $this->getAuthorization();
        if ($transactionAuth == false) {
            return response()->json([
                'msg' => 'transaction denied.',
            ], 403);
        };

        Bus::batch([
            new TransactionJob($data),

        ])->then(function () {
            // All jobs completed successfully...

            $this->addSendsJobToQueue();
        })->catch(function () {
            return response()->json([
                'msg' => 'An error occurred with the transaction. All balances were reverted to their respective accounts.',
            ], 403);
        })->finally(function () {
            // The batch has finished executing... 
        })->dispatch();

        return 'The transaction is being processed.';
    }

    public function executeTransaction($data)
    {
        // throw new Exception("Error Processing Request", 1);
        try {
             //create transaction with status processing
            $objectBd = new DB();
            $objectBd::beginTransaction();
            $data['status_id'] = 1;
            $transaction = $this->modelRepository->save($data);
            
            //get parameters
            $payerUser = $this->userRepository->findbyId($data['sender_user_id']);
            $receivedUser = $this->userRepository->findbyId($data['receiver_user_id']);
            $balancePayer = $payerUser->balance - $data['amount'];
            $balanceReceived = $receivedUser->balance + $data['amount'];

            //update in user
            $this->userRepository->update($payerUser->id, ['balance' => $balancePayer], false);
            $this->userRepository->update($receivedUser->id, ['balance' => $balanceReceived], false);

            //set status to success in transaction
            $this->modelRepository->update($transaction->id, ['status_id' => 2], false);
             $objectBd = new DB();
             $objectBd::commit();
        } catch (\Throwable $th) {
            $objectBd = new DB();
            $objectBd::rollBack();  
        }
    }

    public function addSendsJobToQueue()
    {
        $objSendToPayerJob = new SendEmailToPayerJob($this->data);
        $objSendToReceivedJob = new SendEmailToReceivedJob($this->data);
        $objSendToPayerJob::dispatch($this->data);
        $objSendToReceivedJob::dispatch($this->data);
    }
}
