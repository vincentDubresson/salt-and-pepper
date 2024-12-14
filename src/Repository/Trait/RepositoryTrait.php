<?php

namespace App\Repository\Trait;

use Doctrine\ORM\QueryBuilder;

trait RepositoryTrait
{
    protected function getActiveOptimisedQb(): QueryBuilder
    {
        return $this
            ->getOptimisedQb()
            ->andWhere('e.enabled = 1')
        ;
    }
}
