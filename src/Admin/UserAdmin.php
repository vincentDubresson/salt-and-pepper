<?php

namespace App\Admin;

use App\Entity\Country;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Sonata\DoctrineORMAdminBundle\Filter\StringFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @extends AbstractAdmin<User>
 */
class UserAdmin extends AbstractAdmin
{
    protected function preValidate(object $object): void
    {
        if (!$object instanceof User) {
            throw new \InvalidArgumentException('You must have a User at this point.');
        }

        $object
            ->setUpdatedAt(new \DateTime('now'))
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        /** @var User $user */
        $user = $this->getSubject();
        $userId = $user->getId();

        $form
            ->with('common.infos_1', ['class' => 'col-md-6', 'label' => 'common.infos_1'])
            ->add('firstname', TextType::class, [
                'label' => 'common.firstname',
                'empty_data' => '',
                'required' => true,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'common.lastname',
                'empty_data' => '',
                'required' => true,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('email', EmailType::class, [
                'label' => 'common.email',
                'empty_data' => '',
                'required' => true,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('admin', CheckboxType::class, [
                'label' => 'common.admin',
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'common.enabled',
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->end()
            ->with('common.infos_2', ['class' => 'col-md-6', 'label' => 'common.infos_2'])
            ->add('address1', TextType::class, [
                'label' => 'common.address1',
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('address2', TextType::class, [
                'label' => 'common.address2',
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('city', ModelAutocompleteType::class, [
                'label' => 'Code postal et Ville',
                'placeholder' => 'Saisissez un code postal',
                'property' => 'postalCode',
                'minimum_input_length' => 5,
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->add('country', EntityType::class, [
                'label' => 'common.country',
                'class' => Country::class,
                'placeholder' => 'Choisir un pays',
                'autocomplete' => true,
                'required' => false,
                'disabled' => $userId === User::ADMIN_ID,
            ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('firstname', StringFilter::class, [
                'label' => 'common.firstname',
                'show_filter' => true,
            ])
            ->add('lastname', StringFilter::class, [
                'label' => 'common.lastname',
                'show_filter' => true,
            ])
            ->add('email', StringFilter::class, [
                'label' => 'common.email',
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
            ->add('firstname', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.firstname',
            ])
            ->add('lastname', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.lastname',
            ])
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL, [
                'label' => 'common.email',
            ])
            ->add('roleAsString', FieldDescriptionInterface::TYPE_STRING, [
                'label' => 'common.role',
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
        $collection->clearExcept(['list', 'edit', 'delete', 'export']);
    }

    protected function configureExportFields(): array
    {
        return [
            'ID' => 'id',
            'EMAIL' => 'email',
            'ROLE' => 'roleAsString',
            'CRÉÉ LE' => 'createdAt',
            'MODIFIÉ LE' => 'updatedAt',
        ];
    }
}
