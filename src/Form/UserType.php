<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();

        $builder
            ->add('username', TextType::class)
            // ->add('roles', TextType::class)
            ->add('password', PasswordType::class)
            ->add('name', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'admin' => 'ROLE_ADMIN',
                    'page1' => 'ROLE_PAGE_1',
                    'page2' => 'ROLE_PAGE_2',
                ],
                'expanded' => true,
                'multiple' => true,
                'data' => $entity->getRoles() // Current roles assigned..
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
