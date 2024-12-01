<?php

namespace App\Admin;

use App\Entity\Ingredient;
use App\Entity\RecipesIngredients;
use App\Entity\Unit;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * @extends AbstractAdmin<RecipesIngredients>
 */
class RecipesIngredientsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('common.ingredients', ['class' => 'col-md-6'])
            ->add('quantity', NumberType::class, [
                'label' => 'common.quantity',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Positive(message: 'La quantité doit est positive.'),
                ],
                'required' => true,
            ])
            ->add('unit', EntityType::class, [
                'label' => 'common.unit',
                'class' => Unit::class,
                'placeholder' => 'Choisir une unité si nécessaire',
                'autocomplete' => true,
                'required' => false,
            ])
            ->add('ingredient', EntityType::class, [
                'label' => 'common.ingredient',
                'class' => Ingredient::class,
                'placeholder' => 'Choisir un ingrédient',
                'autocomplete' => true,
                'constraints' => [new NotNull()],
                'required' => true,
            ])
            ->add('sort', NumberType::class, [
                'label' => 'common.sort',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Positive(message: 'Le tri doit est positif.'),
                ],
                'required' => true,
            ])
            ->end()
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->clearExcept(['create', 'edit', 'delete']);
    }
}
