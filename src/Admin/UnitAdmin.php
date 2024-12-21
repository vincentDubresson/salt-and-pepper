<?php

namespace App\Admin;

use App\Entity\Unit;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Sonata\DoctrineORMAdminBundle\Filter\StringFilter;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @extends AbstractAdmin<Unit>
 */
class UnitAdmin extends AbstractAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_BY] = 'sort';
        $sortValues[DatagridInterface::SORT_ORDER] = 'ASC';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('common.infos_1', ['class' => 'col-md-6', 'label' => 'common.infos_1'])
            ->add('label', TextType::class, [
                'label' => 'common.label',
                'empty_data' => '',
                'required' => true,
            ])
            ->add('abbreviation', TextType::class, [
                'label' => 'common.abbreviation',
                'empty_data' => '',
                'required' => true,
            ])
            ->add('pluralizable', CheckboxType::class, [
                'label' => 'common.pluralizable',
                'required' => false,
            ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('label', StringFilter::class, [
                'label' => 'common.label',
                'show_filter' => true,
            ])
            ->add('abbreviation', StringFilter::class, [
                'label' => 'common.abbreviation',
                'show_filter' => true,
            ])
            ->add('pluralizable', BooleanFilter::class, [
                'label' => 'common.pluralizable',
                'show_filter' => true,
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('label', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.label',
            ])
            ->add('abbreviation', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.abbreviation',
            ])
            ->add('pluralizable', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'common.pluralizable',
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

    protected function configureExportFields(): array
    {
        return [
            'ID' => 'id',
            'LIBELLE' => 'label',
            'ABREVIATION' => 'abbreviation',
            'CRÉÉ LE' => 'createdAt',
            'MODIFIÉ LE' => 'updatedAt',
        ];
    }
}
