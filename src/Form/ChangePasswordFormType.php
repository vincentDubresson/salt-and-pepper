<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        new Length([
                            'min' => 12,
                            'minMessage' => 'Votre mot de passe doit comporter au minimum {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                        new PasswordStrength(minScore: PasswordStrength::STRENGTH_MEDIUM),
                        new NotCompromisedPassword(message: 'Ce mot de passe est compromis. Merci de choisir un autre mot de passe.'),
                    ],
                    'label' => 'New password',
                    'help' => 'Votre mot de passe doit comporter au minimum 12 caractères. Nous vous recommandons une mot de passe contenant au moins 1 majuscule, 1 chiffre et 1 caractère spécial.',
                    'always_empty' => false,
                    'toggle' => true,
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'always_empty' => false,
                    'toggle' => true,
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
