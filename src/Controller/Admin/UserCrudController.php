<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserCrudController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            TelephoneField::new('telephone'),
//            Field::new('password','Mot de passe')->setFormType(PasswordType::class),
//            Field::new( 'password', 'Nouveau mot de passe' )->onlyWhenUpdating()->setFormType(PasswordType::class)
//                ->setFormType( RepeatedType::class )
//                ->setFormTypeOptions( [
//                    'type'            => PasswordType::class,
//                    'first_options'   => [ 'label' => 'Nouveau mot de passe' ],
//                    'second_options'  => [ 'label' => 'Répétez le mot de passe' ],
//                    'error_bubbling'  => true,
//                    'invalid_message' => 'Les mots de passe doivent correspondre.',
//                ] ),
            AssociationField::new('campus'),
            ImageField::new('image','Avatar')->setBasePath('uploads/images')->setUploadDir('public/uploads/images'),
            BooleanField::new('isAdministrateur'),
            BooleanField::new('isActif')
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('new','Ajouter un étudiant')
            ->setPageTitle('edit','Modifier étudiant')
            ->setPageTitle('index','Tous les étudiants');
    }

}
