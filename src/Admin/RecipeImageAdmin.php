<?php

namespace App\Admin;

use App\Entity\RecipeImage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NoSuspiciousCharacters;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * @extends AbstractAdmin<RecipeImage>
 */
class RecipeImageAdmin extends AbstractAdmin
{
    protected function preValidate(object $object): void
    {
        if (!$object instanceof RecipeImage) {
            throw new \InvalidArgumentException('You must have a RecipeImage at this point.');
        }

        $object
            ->setUpdatedAt(new \DateTime('now'))
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $subject = $this->getSubject();

        $imageConstraints = [
            new File(
                maxSize: '5M',
                mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
            ),
        ];

        if (!$subject instanceof RecipeImage || !$subject->getImageName()) {
            $imageConstraints[] = new NotBlank(message: 'Vous devez ajouter une image.');
        }

        $form
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'empty_data' => '',
                'constraints' => $imageConstraints,
                'required' => !$subject instanceof RecipeImage || !$subject->getImageName(),
                'allow_delete' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'common.title',
                'empty_data' => '',
                'constraints' => [
                    new Length(
                        max: 255,
                        maxMessage: 'Le titre ne peut pas dépasser 255 caractères.',
                    ),
                    new NoSuspiciousCharacters(),
                ],
                'required' => false,
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
        ;
    }
}
