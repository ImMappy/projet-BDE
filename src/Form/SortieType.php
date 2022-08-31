<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SortieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control mb-3'
                ]
            ])
            ->add('dateHeureDebut',DateTimeType::class,[
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'form-control mb-3'
                ],
                'label' => 'Date début sortie'
            ])
            ->add('duree',NumberType::class,[
                'attr'=> [
                    'class'=>'form-control mb-3'
                ],
                'label'=>'Durée'
            ])
            ->add('dateLimiteInscription',DateTimeType::class,[
                'input'=>'datetime_immutable',
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'form-control mb-3'
                ],
                'label'=> 'Date limite inscription'
            ])
            ->add('nbInscriptionsMax',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control mb-3'
                ],
                'label'=>"Nombre d'inscriptions maximum"
            ])
            ->add('infosSortie',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control mb-3',
                    'style'=>'resize:none;'
                ],
                'label'=>'Informations',

            ])
            ->add('campus',EntityType::class,[
                'class'=>Campus::class,
                'label'=>'Campus',
                'attr'=>[
                    'class'=>'mb-3'
                ],
            ])
            ->add('etat',EntityType::class,[
                'class'=>Etat::class,
                'label'=>'Etat',
                'attr'=>[
                    'class'=>'mb-3'
                ],
            ])
            ->add('lieu',EntityType::class,[
                'class'=>Lieu::class,
                'label'=>'Lieu',
                'attr'=>[
                    'class'=>'mb-3'
                ],
            ])
            ->add('submit',SubmitType::class,[
                'label'=> 'Enregistrer la sortie',
                'attr'=>[
                    'class'=>'mb-3'
                ]
            ])

            ->add('submit2',SubmitType::class,[
                'label'=> 'Publier la sortie',
                'attr'=>[
                    'class'=>'mb-3'
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
