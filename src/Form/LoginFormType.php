<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_username', EmailType::class, [
                'label' => 'common.email',
                'constraints' => [
                    new NotBlank(message: 'Merci de renseigner votre adresse email.'),
                    new Email(message: "Cette adresse email n'est pas au bon format."),
                ],
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'common.password',
                'constraints' => [
                    new NotBlank(message: 'Merci de renseigner votre mot de passe.'),
                ],
                'always_empty' => false,
                'toggle' => true,
            ])
        ;

        $builder->setAttributes([
            'class' => 'max-w-[500px]',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
