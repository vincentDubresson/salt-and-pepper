<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class CityAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'common.city',
            'class' => City::class,
            'placeholder' => 'Entrez un code postal ou une ville',
            // 'choice_label' => 'name',

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            'searchable_fields' => ['postalCode', 'label'],
            'autocomplete' => true,

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
