<?php

namespace App\Interfaces;

interface ServiceInterface {
    public function save($data);
    public function find($idEspecific);
    public function update($data, $idEspecific);
    public function delete($idEspecific);
    public function getUserAuth();
    public function getParameters();
    public function queryApplyFilters($data);
    public function querySelectAttributesEspecific($data);
    public function querySelectRelationshipCascade($data, array $withNameFunctions);
    public function getRecords();
}