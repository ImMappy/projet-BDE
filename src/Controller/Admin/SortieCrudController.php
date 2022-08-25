<?php

namespace App\Controller\Admin;

use App\Entity\Sortie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Sodium\add;

class SortieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sortie::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('nom')
                        ->add('dateHeureDebut') // TODO: Change the autogenerated stub
                        ->add('duree')
                        ->add('dateLimiteInscription')
                        ->add('nbInscriptionsMax')
                        ->add('lieu')
                        ->add('organisateur');
    }

    public function configureFields(string $pageName): iterable
    {
         return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            DateTimeField::new('dateHeureDebut','Date sortie'),
            NumberField::new('duree'),
            DateTimeField::new('dateLimiteInscription'),
            NumberField::new('nbInscriptionsMax',"Nombre d'inscrits maximum"),
            AssociationField::new('campus'),
            AssociationField::new('organisateur'),
            AssociationField::new('lieu'),
            TextEditorField::new('infosSortie'),

        ];
    }

}
