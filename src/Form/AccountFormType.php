<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'empty_data' => '',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'attr' => ['autocomplete' => 'email'],
                'empty_data' => '',
            ])
            ->add('address1', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('address2', TextType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
            ])
            ->add('city', CityAutocompleteField::class, [
                'required' => false,
            ])
            ->add('country', CountryAutocompleteField::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_token_id' => 'my_account_form',
        ]);
    }
}
