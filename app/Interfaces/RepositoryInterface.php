<?php

namespace App\Interfaces;

interface RepositoryInterface {
    public function resolveEntity();
    public function getAll();
    public function findById($id);
    public function update($id, array $data, bool $typeReturn = false);
    public function delete($id);
    public function filter($filters);
    public function selectAttributes($attributes);
    public function getResults();
    public function beginTransaction();
    public function rollBackTransaction();
    public function commitTransaction();
}