<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Nom'
            ])
            ->add('dateHeureDebut',DateTimeType::class,[
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'form-control mb-3'
                ],
                'label' => 'Date début sortie'
            ])
            ->add('campus',EntityType::class,[
                'class'=>Campus::class,
                'label'=>'Campus',
                'attr'=>[
                    'class'=>'form-select mb-3'
                ],
            ])
            ->add('lieu',EntityType::class,[
                'class'=>Lieu::class,
                'label'=>'Lieu',
                'attr'=>[
                    'class'=>'form-select mb-3'
                ],
            ])
            ->add('motif',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'style'=>'resize:none;'
                ],
            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'Annuler',
                'attr'=>[
                    'class'=>'btn btn-danger my-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
