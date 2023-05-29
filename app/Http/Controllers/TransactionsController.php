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

        /**
     * @OA\Post(
     *     tags={"/transactions/"},
     *     path="/make/",
     *     summary="Get especific user",
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="sender_user_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="receiver_user_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="amount",
     *         required=true,
     *         @OA\Schema(type="decimal")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error in database or server."
     *     )
     * )
     */
    public function makeTransaction(TransactionsRequest $request)
    {
        try {

            $response = $this->transactionService->addTransactionJobToQueue($request->all());


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
