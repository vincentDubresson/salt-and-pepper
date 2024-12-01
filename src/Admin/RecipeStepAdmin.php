<?php

namespace App\Admin;

use App\Entity\RecipeStep;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * @extends AbstractAdmin<RecipeStep>
 */
class RecipeStepAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('step', NumberType::class, [
                'label' => 'common.step',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Positive(message: 'Le numéro d\'étape doit est positif.'),
                ],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'common.description',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NoSuspiciousCharacters(),
                ],
                'required' => false,
            ])
        ;
    }
}
