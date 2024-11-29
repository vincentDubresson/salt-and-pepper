<?php

namespace App\Admin;

use App\Entity\Recipe;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @extends AbstractAdmin<Recipe>
 */
class RecipeAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('label', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.label',
            ])
//            ->add('subcategory')
            ->add('difficulty', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.difficulty',
                'associated_property' => 'id',
                'template' => 'admin/recipe/list/row_difficulty.html.twig',
            ])
            ->add('cost', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.cost',
                'associated_property' => 'id',
                'template' => 'admin/recipe/list/row_cost.html.twig',
            ])
            ->add('enabled', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'common.enabled',
            ])
            ->add('user', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.author',
                'associated_property' => 'id',
            ])
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'common.created_at',
                'format' => 'd/m/Y',
            ])
            ->add('updatedAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'common.updated_at',
                'format' => 'd/m/Y',
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label' => 'common.actions',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['list', 'create', 'edit', 'delete', 'export']);
    }

    // TODO : Gérer l'export
}
