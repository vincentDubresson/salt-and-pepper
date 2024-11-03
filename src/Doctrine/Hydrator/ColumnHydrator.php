<?php

namespace App\Doctrine\Hydrator;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

/**
 * Class ColumnHydrator.
 *
 * Used to hydrate results as a non-associative scalar array.
 */
class ColumnHydrator extends AbstractHydrator
{
    /**
     * @return array<mixed>
     *
     * @throws \Doctrine\DBAL\Exception
     */
    protected function hydrateAllData(): array
    {
        return ($this->stmt) ? $this->stmt->fetchFirstColumn() : [];
    }
}
