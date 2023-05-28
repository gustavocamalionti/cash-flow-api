<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\NotEntityDefined;
use App\Interfaces\RepositoryInterface;


abstract class BaseRepository implements RepositoryInterface
{

    protected $entity;


    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }


    public function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new NotEntityDefined;
        }

        return app($this->entity());
    }

    public function getAll()
    {
        return $this->entity->get();
    }

    public function findById($idEspecific)
    {
        return $this->entity->find($idEspecific);
    }

    public function save(array $data)
    {
        return $this->entity->create($data);
    }


    public function update($idEspecific, array $data, $typeReturn)
    {
        $entity = $this->findById($idEspecific)->fill($data);
        $returnBool = $entity->save();

        return (!$typeReturn ? $returnBool : $entity);
    }

    public function delete($idEspecific)
    {
        return $this->entity->find($idEspecific)->delete();
    }

    /**
     * implements relationship. Query is building in entity.
     */
    public function displayRelationship($attributes){
        $this->entity = $this->entity->with($attributes);
       
    }

    /**
     * Add condition in select. Query is building in entity.
     */
    public function filter($filters)
    {
        $filters = explode(';', $filters);

        foreach ($filters as $condition) {

            $column = explode(':', $condition);

            //$c[0] - column
            //$c[1] - condition
            //$c[2] - value

            $this->entity = $this->entity->where($column[0], $column[1], $column[2]);
        }
    }

    /**
     * filter attributes in select. Query is building in entity.
     */
    public function selectAttributes($attributes)
    {
        $this->entity = $this->entity->selectRaw($attributes);
    }
}
