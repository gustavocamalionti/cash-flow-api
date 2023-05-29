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
     * @OA\Get(
     *     tags={"/users/"},
     *     path="/users/",
     *     summary="Display a listing of users.",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error in database or server."
     *     )
     * )
     * 
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        try {
            $this->userService->queryApplyFilters($request);
            $this->userService->querySelectAttributesEspecific($request);
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
     * @OA\Post(
     *     tags={"/users/"},
     *     path="/users/",
     *     summary="Insert new user",
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="document",
     *         required=true,
     *         @OA\Schema(type="integer") 
     * ),
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="balance",
     *         required=true,
     *     ),
     *      @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="password",
     *         required=true,
     *         @OA\Schema(type="string")
     * 
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
    public function store(StoreUsersRequest $request)
    {
        try {
            $response = $this->userService->save($request->all());

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
     * @OA\Get(
     *     tags={"/users/"},
     *     path="/users/{id}",
     *     summary="Get especific user",
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
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
    public function show($idEspecific)
    {
        try {
            $response = $this->userService->find($idEspecific);

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
     * @OA\Patch(
     *     tags={"/users/"},
     *     path="/users/{id}",
     *     summary="Update information to user",
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
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
    public function update(UpdateUsersRequest $request, $idEspecific)
    {
        try {
            $user = $this->userService->find($idEspecific);
            if ($user == null) {
                return response()->json([
                    'msg' => 'Unable to perform the update. The requested resource does not exist.'
                ], 404);
            }

            /* If there is an id in the body of the request, eloquent has the intelligence to update (UPDATE) the
            record, otherwise insert(INSERT), respecting the RESTFul*/
            $user = $this->userService->update($request->all(), $idEspecific);

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
     * @OA\Delete(
     *     tags={"/users/"},
     *     path="/users/{id}",
     *     summary="Get especific user",
     *     @OA\Parameter(
     *         description="Description example.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
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
    public function destroy($idEspecific)
    {
        try {
            $user = $this->userService->find($idEspecific);

            if ($user == null) {
                return response()->json([
                    'msg' => 'Unable to perform deletion. The requested resource does not exist.'
                ], 404);
            }

            $user = $this->userService->delete($idEspecific);

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
