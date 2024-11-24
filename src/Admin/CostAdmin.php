<?php

namespace App\Admin;

use App\Entity\Cost;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @extends AbstractAdmin<Cost>
 */
class CostAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('label', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.label',
            ])
            ->add('sort', FieldDescriptionInterface::TYPE_FLOAT, [
                'label' => 'common.sort',
                'scale' => 2,
            ])
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['list', 'export']);
    }

    protected function configureExportFields(): array
    {
        return [
            'ID' => 'id',
            'LIBELLE' => 'label',
            'ORDRE' => 'sort',
            'CRÉÉ LE' => 'createdAt',
            'MODIFIÉ LE' => 'updatedAt',
        ];
    }
}
