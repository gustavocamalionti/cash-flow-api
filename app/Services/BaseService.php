<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class BaseService implements ServiceInterface

{
    protected $modelRepository;

    public function save($data)
    {
        return $this->modelRepository->save($data->all());
    }

    public function find($id)
    {
        return $this->modelRepository->findById($id);
    }

    public function update($data, $id)
    {
        return $this->modelRepository->update($id, $data->all(), true);
    }

    public function delete($id)
    {
        return $this->modelRepository->delete($id);
    }

    /**
     * Retrieve authenticated user information
     */
    public function getUserAuth()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Get general appication parameters. Example: start and end time allowing transfers in day.
     */
    public function getParameters()
    {
        // return $this->parametersRepository->findById(1);
    }

    public function QueryApplyFilters($data)
    {
       
        //Query is building in entity.
        if ($data->has('filter')) {
            $this->modelRepository->filter($data->filter);
        }
    }

    public function QuerySelectAttributesEspecific($data){
        //Query is building in entity.
        if ($data->has('attr')) {
            $this->modelRepository->selectAttributes($data->attr);
        }
    }

    public function QuerySelectRelationshipCascade($data, array $with_name_functions){
        // Query is building in entity.
        if (!$data->has("relationship") || $data->relationship == 'true') {
            foreach ($with_name_functions as $key => $value) {   
                $this->modelRepository->displayRelationship($value);
            }
        };
    }

    public function getRecords()
    {
        return $this->modelRepository->getAll();
    }
}
