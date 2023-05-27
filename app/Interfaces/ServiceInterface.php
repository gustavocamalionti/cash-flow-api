<?php

namespace App\Interfaces;

interface ServiceInterface {
    public function getUserAuth();
    public function getParameters();
    public function QueryApplyFilters($data);
    public function QuerySelectAttributesEspecific($data);
    public function QuerySelectRelationshipCascade($data, array $name_functions_relationship);
    public function getRecords();
}