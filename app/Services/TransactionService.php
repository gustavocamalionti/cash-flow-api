<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\TransactionRepository;

class TransactionService extends BaseService
{
    protected $modelRepository;
    protected $userRepository;

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

    public function getBalanceInAccount($id){
        $user = $this->userRepository->findById($id);
        if ($user == null or $user == "") {
            return 0;
        }
       return $user->balance;
    }

    public function addJobTransactionToQueue($data){

        // $this->dispatch(generateTransaction());

        return 'The transaction is being processed';

    }

    public function generateTransaction(){

        $this->modelRepository->beginTransaction();
        $this->modelRepository->rollBackTransaction();
        $this->modelRepository->commitTransaction();
    }

    public function getAuthorization(){
        $response = Http::accept('application/json')->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->json();

        if ($response['message'] == 'Autorizado') {
            return true;
        } else {
            return false;
        };
       
    }

    public function sendEmailToPayer($data) {
        
    
    }
    public function sendEmailToReceived($data) {

    }
}