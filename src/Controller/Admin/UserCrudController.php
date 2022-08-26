<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

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
            TextField::new('password')->setFormType(PasswordType::class),
            AssociationField::new('campus'),
            ImageField::new('image','Avatar')->setBasePath('uploads/images')->setUploadDir('public/uploads/images'),
            BooleanField::new('isAdministrateur'),
            BooleanField::new('isActif')
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('new','Ajouter un étuidiant')
            ->setPageTitle('edit','Modifier étudiant')
            ->setPageTitle('index','Tous les étudiants');
    }

}
