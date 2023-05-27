<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use App\Http\Requests\UpdateUsersRequest;

class UsersController extends Controller
{

    protected $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $this->userService->QueryApplyFilters($request);
            $this->userService->QuerySelectAttributesEspecific($request);
            $response = $this->userService->getRecords();

            //Query is building in entity.
            return response()->json([
                'msg' => 'Recursos encontrados.',
                'data' => $response
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $response = $this->userService->saveUser($request);

            return response()->json([
                'msg' => 'Criado com sucesso',
                'data' => $response
            ], 201);

        } catch (QueryException $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 404);  
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
