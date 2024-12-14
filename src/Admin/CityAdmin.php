<?php

namespace App\Admin;

use App\Entity\City;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @extends AbstractAdmin<City>
 */
class CityAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('postalCode')
            ->add('label')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('postalCode')
            ->add('label')
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['list']);
    }
}
