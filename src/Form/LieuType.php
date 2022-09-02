<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control m-1'
                ],
                'label'=>'Nom'
            ])
            ->add('rue',TextType::class,[
                'attr'=>[
                    'class'=>'form-control m-1'
                ],
                'label'=>'Rue'
            ])
            ->add('latitude',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control m-1'
                ],
                'label'=>'Latitude'
            ])
            ->add('longitude',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control m-1'
                ],
                'label'=>'Longitude'])
            ->add('ville',EntityType::class,[
                'class'=>Ville::class,
                'attr'=>[
                    'class'=>'form-select m-1'
                ],
                'label'=>'Ville'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
