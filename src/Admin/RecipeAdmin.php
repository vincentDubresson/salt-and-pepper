<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\CookingType;
use App\Entity\Cost;
use App\Entity\Difficulty;
use App\Entity\Recipe;
use App\Entity\Subcategory;
use App\Entity\User;
use App\Service\RecipeService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Sonata\DoctrineORMAdminBundle\Filter\StringFilter;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @extends AbstractAdmin<Recipe>
 */
class RecipeAdmin extends AbstractAdmin
{
    public function __construct(
        private readonly RecipeService $recipeService,
        private readonly Security $security,
    ) {
        parent::__construct(Recipe::class);
    }

    protected function prePersist(object $object): void
    {
        if (!$object instanceof Recipe) {
            throw new \InvalidArgumentException('You must have a Recipe at this point.');
        }

        if ($this->isCurrentRoute('create')) {
            /** @var TokenInterface $token */
            $token = $this->security->getToken();
            /** @var User $user */
            $user = $token->getUser();

            $reference = $this->recipeService->generateRecipeReference($object);

            $object
                ->setUser($user)
                ->setReference($reference)
            ;
        }
        dd($object);
    }

    protected function preUpdate(object $object): void
    {
        if (!$object instanceof Recipe) {
            throw new \InvalidArgumentException('You must have a Recipe at this point.');
        }

        $object->setUpdatedAt(new \DateTime());
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->tab('General', ['label' => 'common.infos_1'])
            ->with('common.main_feature', ['class' => 'col-md-6', 'label' => 'common.main_feature'])
            ->add('reference', TextType::class, [
                'label' => 'common.reference',
                'attr' => [
                    'placeholder' => 'La référence sera autogénérée.',
                ],
                'required' => false,
                'disabled' => true,
            ])
            ->add('label', TextType::class, [
                'label' => 'common.recipe_name',
                'empty_data' => '',
                'required' => true,
            ])
            ->add('slug', TextType::class, [
                'label' => 'common.slug',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Le slug sera autogénéré.',
                ],
                'required' => false,
                'disabled' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'common.description',
                'empty_data' => '',
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'label' => 'common.author',
                'class' => User::class,
                'placeholder' => 'Vous serez automatiquement assigné à cette recette.',
                'autocomplete' => true,
                'required' => false,
                'disabled' => true,
            ])
            ->add('metaDescription', TextareaType::class, [
                'label' => 'common.meta_description',
                'empty_data' => '',
                'required' => false,
            ])
            ->add('metaKeywords', TextareaType::class, [
                'label' => 'common.meta_keywords',
                'empty_data' => '',
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'common.in_line',
                'required' => false,
            ])
            ->end()
            ->with('common.secondary_feature', ['class' => 'col-md-6', 'label' => 'common.secondary_feature'])
            ->add('subcategory', EntityType::class, [
                'label' => 'common.subcategory',
                'class' => Subcategory::class,
                'choice_label' => function (Subcategory $subCategory) {
                    $category = $subCategory->getCategory();

                    return $category->getLabel() . ' - ' . $subCategory->getLabel();
                },
                'placeholder' => 'Choisir une sous-catégorie',
            ])
            ->add('servingNumber', NumberType::class, [
                'label' => 'common.serving_number',
                'empty_data' => '',
                'required' => true,
            ])
            ->add('difficulty', EntityType::class, [
                'label' => 'common.difficulty',
                'class' => Difficulty::class,
                'placeholder' => 'Choisir une difficulté',
                'autocomplete' => true,
                'required' => true,
            ])
            ->add('cost', EntityType::class, [
                'label' => 'common.cost',
                'class' => Cost::class,
                'placeholder' => 'Choisir un budget',
                'autocomplete' => true,
                'required' => true,
            ])
            ->add('cookingType', EntityType::class, [
                'label' => 'common.cooking_type',
                'class' => CookingType::class,
                'placeholder' => 'Choisir un type de cuisson',
                'autocomplete' => true,
                'required' => true,
            ])
            ->add('preparationTime', TimeType::class, [
                'label' => 'common.preparation_time',
                'input' => 'datetime',
                'by_reference' => false,
            ])
            ->add('cookingTime', TimeType::class, [
                'label' => 'common.cooking_time',
                'input' => 'datetime',
                'by_reference' => false,
            ])
            ->add('restingTime', TimeType::class, [
                'label' => 'common.resting_time',
                'input' => 'datetime',
                'by_reference' => false,
            ])
            ->end()
            ->end()
            ->tab('Ingredients', ['label' => 'common.ingredients'])
            ->with('Ingredients', ['label' => 'common.ingredients'])
            ->add('recipesIngredients', CollectionType::class, [
                'label' => false,
                'by_reference' => true,
                'btn_add' => 'common.add_ingredient',
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->end()
            ->end()
            ->tab('Steps', ['label' => 'common.steps'])
            ->with('Steps', ['label' => 'common.steps'])
            ->add('recipeSteps', CollectionType::class, [
                'label' => false,
                'by_reference' => true,
                'btn_add' => 'common.add_step',
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->end()
            ->end()
            ->tab('Images', ['label' => 'common.images'])
            ->with('Images', ['label' => 'common.images'])
            ->add('recipeImages', CollectionType::class, [
                'label' => false,
                'by_reference' => true,
                'btn_add' => 'common.add_image',
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('label', StringFilter::class, [
                'label' => 'common.recipe_name',
                'show_filter' => true,
            ])
            ->add('subcategory.category', ModelFilter::class, [
                'label' => 'common.category',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Category::class,
                    'autocomplete' => true,
                ],
                'show_filter' => true,
            ])
            ->add('subcategory', ModelFilter::class, [
                'label' => 'common.subcategory',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Subcategory::class,
                    'autocomplete' => true,
                ],
                'show_filter' => true,
            ])
            ->add('difficulty', ModelFilter::class, [
                'label' => 'common.difficulty',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Difficulty::class,
                    'autocomplete' => true,
                ],
                'show_filter' => true,
            ])
            ->add('cost', ModelFilter::class, [
                'label' => 'common.cost',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => Cost::class,
                    'autocomplete' => true,
                ],
                'show_filter' => true,
            ])
            ->add('user', ModelFilter::class, [
                'label' => 'common.author',
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => User::class,
                    'autocomplete' => true,
                ],
                'show_filter' => true,
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
            ->add('label', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.recipe_name',
            ])
            ->add('subcategory.category', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.category',
                'associated_property' => 'id',
            ])
            ->add('subcategory', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.subcategory',
                'associated_property' => 'id',
            ])
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
            ->add('views', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.views',
                'template' => 'admin/recipe/list/count_recipe_user_favorites.html.twig',
            ])
            ->add('countRecipeUserFavorites', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.recipe_user_favorites',
                'template' => 'admin/recipe/list/count_recipe_user_favorites.html.twig',
            ])
            ->add('countRecipesComments', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.recipes_comments',
                'template' => 'admin/recipe/list/count_recipes_comments.html.twig',
            ])
            ->add('enabled', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'label' => 'common.enabled',
            ])
            ->add('user', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.author',
                'associated_property' => 'id',
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
