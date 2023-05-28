<?php

namespace App\Services;

use Exception;
use Throwable;
use Illuminate\Bus\Batch;
use App\Jobs\TransactionJob;
use App\Jobs\SendEmailToPayerJob;
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

    public function verifyDocumentType($id)
    {
        $user = $this->userRepository->findById($id);
        if ($user == null or $user == "") {
            return null;
        }

        if (strlen($user->document) == 14) {
            return 'cnpj';
        } else {
            return 'cpf';
        }
    }

    public function getBalanceInAccount($id)
    {
        $user = $this->userRepository->findById($id);
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
        } else {
            return false;
        };
    }

    public function addTransactionJobToQueue($data)
    {
        $this->data = $data;
        $TransactionAuthorized = $this->getAuthorization();
        if ($TransactionAuthorized == false) {
            return response()->json([
                'msg' => 'transaction denied.',
            ], 403);
        }; 

        Bus::batch([
            new TransactionJob($data),

        ])->then(function (Batch $batch) {
            // All jobs completed successfully...
            $this->addEmailSendsJobToQueue();
            
        })->catch(function (Batch $batch, Throwable $e) {
            return response()->json([
                'msg' => 'An error occurred with the transaction. All balances were reverted to their respective accounts.',
            ], 403);
        })->finally(function (Batch $batch) {
            // The batch has finished executing... 
        })->dispatch();

        return 'The transaction is being processed.';
    }

    public function executeTransaction()
    {
        $this->modelRepository->beginTransaction();
        $this->modelRepository->rollBackTransaction();
        $this->modelRepository->commitTransaction();
    }

    public function addEmailSendsJobToQueue()
    {
        SendEmailToPayerJob::dispatch($this->data);
        SendEmailToReceivedJob::dispatch($this->data);
    }

}
