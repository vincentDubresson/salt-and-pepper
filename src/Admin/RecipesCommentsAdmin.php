<?php

namespace App\Admin;

use App\Entity\Recipe;
use App\Entity\RecipesComments;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @extends AbstractAdmin<RecipesComments>
 */
class RecipesCommentsAdmin extends AbstractAdmin
{
    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /* @phpstan-ignore-next-line */
        $rootAlias = current($query->getRootAliases());

        /* @phpstan-ignore-next-line */
        $query->addOrderBy($rootAlias . '.enabled', 'ASC');
        /* @phpstan-ignore-next-line */
        $query->addOrderBy($rootAlias . '.createdAt', 'ASC');

        return $query;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('common.infos_1', ['class' => 'col-md-6', 'label' => 'common.infos_1'])
            ->add('user', EntityType::class, [
                'label' => 'common.author',
                'class' => User::class,
                'required' => false,
                'disabled' => true,
            ])
            ->add('recipe', EntityType::class, [
                'label' => 'common.recipe',
                'class' => Recipe::class,
                'required' => false,
                'disabled' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'common.recipes_comment',
                'empty_data' => '',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'common.enabled',
                'required' => false,
            ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('user', ModelFilter::class, [
                'label' => 'common.author',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => User::class,
                    'autocomplete' => true,
                ],
            ])
            ->add('recipe', ModelFilter::class, [
                'label' => 'common.recipe',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Recipe::class,
                    'autocomplete' => true,
                ],
            ])
            ->add('enabled', BooleanFilter::class, [
                'label' => 'common.enabled',
                'show_filter' => true,
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('recipe', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.recipe',
                'associated_property' => 'id',
            ])
            ->add('user', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.author',
                'associated_property' => 'id',
            ])
            ->add('comment', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.recipes_comment',
                'template' => 'admin/recipesComments/list/recipes_comments.html.twig',
            ])
            ->add('enabled', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'common.enabled',
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
        $collection->clearExcept(['list', 'edit', 'delete']);
    }
}
