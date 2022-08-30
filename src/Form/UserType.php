<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]

            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                    ]
                ])
            ->add('prenom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('telephone',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('Roles', ChoiceType::class, [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('isAdministrateur')
            ->add('isActif')
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-outline-success my-4 text-center md-'
                ],
                'label'=>'Valider'
            ])

        ;
        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
