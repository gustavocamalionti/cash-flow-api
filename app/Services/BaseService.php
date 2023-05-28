<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class BaseService implements ServiceInterface

{
    protected $modelRepository;

    public function save($data)
    {
        return $this->modelRepository->save($data);
    }

    public function find($idEspecific)
    {
        return $this->modelRepository->findByid($idEspecific);
    }

    public function update($data, $idEspecific)
    {
        return $this->modelRepository->update($idEspecific, $data, true);
    }

    public function delete($idEspecific)
    {
        return $this->modelRepository->delete($idEspecific);
    }

    /**
     * Retrieve authenticated user information
     */
    public function getUserAuth()
    {
        $objAuth = new Auth();

        $user = $objAuth::user();
        return $user;
    }

    /**
     * Get general appication parameters. Example: start and end time allowing transfers in day.
     */
    public function getParameters()
    {
        // return $this->parametersRepository->findById(1);
    }

    public function queryApplyFilters($data)
    {
        //Query is building in entity.
        if ($data->has('filter')) {
            $this->modelRepository->filter($data->filter);
        }
    }

    public function querySelectAttributesEspecific($data){
        //Query is building in entity.
        if ($data->has('attr')) {
            $this->modelRepository->selectAttributes($data->attr);
        }
    }

    public function querySelectRelationshipCascade($data, array $withNameFunctions){
        // Query is building in entity.
        if (!$data->has("relationship") || $data->relationship == 'true') {
            foreach ($withNameFunctions as $value) {   
                $this->modelRepository->displayRelationship($value);
            }
        };
    }

    public function getRecords()
    {
        return $this->modelRepository->getAll();
    }
}
