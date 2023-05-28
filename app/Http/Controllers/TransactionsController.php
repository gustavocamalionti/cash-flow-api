<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use Illuminate\Database\QueryException;
use App\Http\Requests\TransactionsRequest;

class TransactionsController extends Controller
{
    protected $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function makeTransaction(TransactionsRequest $request)
    {
        try {
            $TransactionAuthorized = $this->transactionService->getAuthorization();
            if ($TransactionAuthorized == false) {
                return response()->json([
                    'msg' => 'Erro',
                    'data' => [
                        'message' => 'Não Autorizado'
                    ]
                ], 403);
            };
            $response = $this->transactionService->addJobTransactionToQueue($request->all());
            $this->transactionService->sendEmailToPayer($request->all());
            $this->transactionService->sendEmailToReceived($request->all());

            return response()->json([
                'msg' => $response
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
