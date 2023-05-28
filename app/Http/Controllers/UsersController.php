<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;

class UsersController extends Controller
{

    protected $userService;
    public function __construct(UserService $userService)
    {
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
                'msg' => 'success.',
                'data' => $response
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        try {
            $response = $this->userService->save($request);

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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $response = $this->userService->find($id);

            if ($response == null) {
                return response()->json(
                    [
                        'msg' => 'Searched resource does not exist.'
                    ],
                    404
                );
            }
            return response()->json([
                'msg' => 'success.',
                'data' => $response
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        try {
            $user = $this->userService->find($id);
            if ($user == null) {
                return response()->json([
                    'msg' => 'Unable to perform the update. The requested resource does not exist.'
                ], 404);
            }

            /* If there is an id in the body of the request, eloquent has the intelligence to update (UPDATE) the
            record, otherwise insert(INSERT), respecting the RESTFul*/
            $user = $this->userService->update($request, $id);

            return response()->json([
                'msg' => 'Feature updated successfully.',
                'data' => $user
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = $this->userService->find($id);

            if ($user == null) {
                return response()->json([
                    'msg' => 'Unable to perform deletion. The requested resource does not exist.'
                ], 404);
            }

            $user = $this->userService->delete($id);

            return response()->json([
                'msg' => 'The feature has been successfully removed!'
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
