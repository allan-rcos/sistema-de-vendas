<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;

interface RepositoryInterface
{
    public function createFindAllQueryBuilder(): QueryBuilder;
}