<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Repositories\UserRepository;

class UsersController extends Controller
{

    protected $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // //Query is building in entity.
            // if (!$request->has("relationship") || $request->relationship == 'true') { //selecionar atributos de reward_group / relacionamento
            //     $this->userRepository->displayRelationship('cities.states');
            //     $this->userRepository->displayRelationship('permissions');
            // };

            //Query is building in entity.
            if ($request->has('filter')) {
                $this->userRepository->filter($request->filter);
            }

            //Query is building in entity.
            if ($request->has('attr')) { 
                $this->userRepository->selectAttributes($request->attr);
            }

            //Query is building in entity.
            return response()->json([
                'msg' => 'Recursos encontrados.',
                'data' => $this->userRepository->getResults()
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
    public function store(StoreUsersRequest $request)
    {
        //
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
