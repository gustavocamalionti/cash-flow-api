<?php

namespace App\Interfaces;

interface ServiceInterface {
    public function save($data);
    public function find($id);
    public function update($data, $id);
    public function delete($id);
    public function getUserAuth();
    public function getParameters();
    public function QueryApplyFilters($data);
    public function QuerySelectAttributesEspecific($data);
    public function QuerySelectRelationshipCascade($data, array $name_functions_relationship);
    public function getRecords();
}