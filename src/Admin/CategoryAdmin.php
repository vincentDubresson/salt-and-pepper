<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\NumberFilter;
use Sonata\DoctrineORMAdminBundle\Filter\StringFilter;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @extends AbstractAdmin<Category>
 */
class CategoryAdmin extends AbstractAdmin
{
    protected function preValidate(object $object): void
    {
        if (!$object instanceof Category) {
            throw new \InvalidArgumentException('You must have a Category at this point.');
        }

        $object
            ->setUpdatedAt(new \DateTime('now'))
        ;
    }

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
            ->add('sort', NumberType::class, [
                'label' => 'common.sort',
                'empty_data' => '',
                'required' => true,
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
            ->add('sort', NumberFilter::class, [
                'label' => 'common.sort',
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
            ->add('sort', FieldDescriptionInterface::TYPE_FLOAT, [
                'label' => 'common.sort',
                'scale' => 2,
                'editable' => true,
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
            'ORDRE' => 'sort',
            'CRÉÉ LE' => 'createdAt',
            'MODIFIÉ LE' => 'updatedAt',
        ];
    }
}
