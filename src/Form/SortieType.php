<?php

namespace App\Form;

use App\Entity\Sortie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                    'class'=>'form-control'
                ]
            ])
            ->add('dateHeureDebut')
            ->add('duree',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label' => 'Date Debut'
            ])
            ->add('dateLimiteInscription',DateType::class,[
                'input'  => 'datetime_immutable',
                'label' => 'Date limite inscription'
            ])
            ->add('nbInscriptionsMax',NumberType::class,[
                'attr'=> [
                    'class'=>'form-control',
                ],
                'label'=>"Nombre d'inscriptions maximum"
            ])
            ->add('infosSortie',TextareaType::class,[
                'attr'=> [
                    'class'=>'form-control',
                    'style'=>'resize:none'
                ],
                'label'=>'Informations'
            ])
            ->add('etat',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label' => 'État'
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-outline-success mx-5'
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
