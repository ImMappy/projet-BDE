<?php

namespace App\Form;

use App\Entity\Lieu;
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
                    'class'=>'form-control'
                ],
                'label'=>'Nom'
            ])
            ->add('rue',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Rue'
            ])
            ->add('latitude',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Latitude'
            ])
            ->add('longitude',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Longitude'])
            ->add('ville',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Rue'
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
