<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('dateHeureDebut',DateType::class)
            ->add('duree',NumberType::class,[
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=>'Date début sortie'
            ])
            ->add('dateLimiteInscription',DateType::class)
            ->add('nbInscriptionsMax',NumberType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>"Date limite d'inscription"
            ])
            ->add('infosSortie',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Informations'
            ])
            ->add('campus',EntityType::class,[
                'class'=>Campus::class,
                'label'=>'Campus'
            ])
            ->add('etat',EntityType::class,[
                'class'=>Etat::class,
                'label'=>'Etat'
            ])
            ->add('lieu',EntityType::class,[
                'class'=>Lieu::class,
                'label'=>'Lieu'
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
