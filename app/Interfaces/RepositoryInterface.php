<?php

namespace App\Interfaces;

interface RepositoryInterface {
    public function resolveEntity();
    public function getAll();
    public function findById($idEspecific);
    public function update($idEspecific, array $data, bool $typeReturn);
    public function delete($idEspecific);
    public function displayRelationship($attributes);
    public function filter($filters);
    public function selectAttributes($attributes);
}