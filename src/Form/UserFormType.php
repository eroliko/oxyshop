<?php

declare(strict_types=1);

namespace App\Form;

use App\Controller\FakeUserRoleController;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    /**
     * @param \App\Controller\FakeUserRoleController $roleController
     */
    public function __construct(
        private readonly FakeUserRoleController $roleController
    )
    {
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void
    {
        $builder
            ->add(User::ATTR_NAME)
            ->add('plainPassword', RepeatedType::class, [
                'type'              => PasswordType::class,
                'mapped'            => false,
                'first_options'     => ['label' => 'Password'],
                'second_options'    => ['label' => 'Confirm password'],
                'invalid_message' => 'The password fields must match.',
            ])
            ->add(User::ATTR_EMAIL, EmailType::class)
            ->add(User::ATTR_TYPE, ChoiceType::class, [
                'choices' => \array_flip($this->roleController->getRoles())
            ])
            ->add('Register', SubmitType::class)
            ->setAction('/users')
            ->setMethod('POST')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false
        ]);
    }
}
