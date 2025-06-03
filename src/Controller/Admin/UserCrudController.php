<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PasswordField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // 1) ID (uniquement sur la liste)
        yield IdField::new('id')->onlyOnIndex();

        // 2) Email (toujours affiché)
        yield EmailField::new('email');

        // 3) Affichage des rôles dans la liste
        yield ArrayField::new('roles')
            ->setLabel('Rôles')
            ->onlyOnIndex();

        // 4) Édition/Création des rôles via ChoiceField multiple
        yield ChoiceField::new('roles')
            ->setLabel('Rôles')
            ->setChoices([
                'Utilisateur'    => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->allowMultipleChoices()
            ->onlyOnForms();

        // 5) Mot de passe (uniquement dans les formulaires create/edit)
        yield TextField::new('password')
    ->onlyOnForms()
    ->setFormType(PasswordType::class);

        // 6) Si votre entité User a un booléen isActive, on l’affiche ici
        if (property_exists(User::class, 'isActive')) {
            yield BooleanField::new('isActive', 'Actif');
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }

        // Si un mot de passe a été saisi, on le hash avant d’enregistrer
        if ($entityInstance->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            );
            $entityInstance->setPassword($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
