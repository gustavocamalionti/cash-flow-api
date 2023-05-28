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

    public function findById($id)
    {
        return $this->entity->find($id);
    }

    public function save(array $data)
    {
        return $this->entity->create($data);
    }


    public function update($id, array $data, bool $typeReturn = false)
    {
        $entity = $this->findById($id)->fill($data);
        $returnBool = $entity->save();

        return (!$typeReturn ? $returnBool : $entity);
    }

    public function delete($id)
    {
        return $this->entity->find($id)->delete();
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

        foreach ($filters as $key => $condition) {

            $c = explode(':', $condition);

            //$c[0] - column
            //$c[1] - condition
            //$c[2] - value

            $this->entity = $this->entity->where($c[0], $c[1], $c[2]);
        }
    }

    /**
     * filter attributes in select. Query is building in entity.
     */
    public function selectAttributes($attributes)
    {
        $this->entity = $this->entity->selectRaw($attributes);
    }

    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function rollBackTransaction(): void
    {
        DB::rollBack();
    }

    public function commitTransaction(): void
    {
        DB::commit();
    }
}
