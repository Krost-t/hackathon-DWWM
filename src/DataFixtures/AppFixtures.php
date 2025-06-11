<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\ImageProduit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des catégories
        $categories = [
            'homme' => new Categorie(),
            'femme' => new Categorie(),
            'enfant' => new Categorie()
        ];

        foreach ($categories as $nom => $categorie) {
            $categorie->setNomCategorie($nom);
            $manager->persist($categorie);
        }

        // Création des types
        $types = [
            'baskets' => new Type(),
            'chaussures' => new Type(),
            'bottes' => new Type(),
            'sandales' => new Type()
        ];

        foreach ($types as $nom => $type) {
            $type->setNomType($nom);
            $manager->persist($type);
        }

        // Création des utilisateurs
        $users = [
            [
                'email' => 'jean.dupont@example.com',
                'password' => 'password123',
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'age' => 35
            ],
            [
                'email' => 'marie.martin@example.com',
                'password' => 'password123',
                'nom' => 'Martin',
                'prenom' => 'Marie',
                'age' => 28
            ],
            [
                'email' => 'pierre.durand@example.com',
                'password' => 'password123',
                'nom' => 'Durand',
                'prenom' => 'Pierre',
                'age' => 42
            ],
            [
                'email' => 'sophie.leroy@example.com',
                'password' => 'password123',
                'nom' => 'Leroy',
                'prenom' => 'Sophie',
                'age' => 31
            ],
            [
                'email' => 'lucas.petit@example.com',
                'password' => 'password123',
                'nom' => 'Petit',
                'prenom' => 'Lucas',
                'age' => 25
            ]
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(true);
            $user->setNom($userData['nom']);
            $user->setPrenom($userData['prenom']);
            $user->setAge($userData['age']);
            $manager->persist($user);
        }

        // Liste de noms de produits réalistes (extraits de grandes marques)
        $nomsProduits = [
            'Nike Air Max',
            'Adidas Stan Smith',
            'Puma Suede',
            'Reebok Classic',
            'New Balance 574',
            'Converse Chuck Taylor',
            'Vans Old Skool',
            'Asics Gel Lyte',
            'Fila Disruptor',
            'Saucony Jazz',
            'Nike Air Force 1',
            'Adidas Superstar',
            'Puma Cali',
            'Reebok Club C',
            'New Balance 997',
            'Converse One Star',
            'Vans Authentic',
            'Asics Gel Kayano',
            'Fila Ray',
            'Saucony Shadow',
            'Nike Blazer',
            'Adidas Gazelle',
            'Puma RS-X',
            'Reebok Aztrek',
            'New Balance 990',
            'Converse All Star',
            'Vans Era',
            'Asics Gel Nimbus',
            'Fila Mindblower',
            'Saucony Grid',
            'Nike Cortez',
            'Adidas NMD',
            'Puma Basket',
            'Reebok Workout',
            'New Balance 1500',
            'Converse Jack Purcell',
            'Vans Sk8-Hi',
            'Asics Gel Saga',
            'Fila Original Fitness',
            'Saucony DXN',
            'Nike React',
            'Adidas ZX',
            'Puma Ignite',
            'Reebok DMX',
            'New Balance 860',
            'Converse Fastbreak',
            'Vans Slip-On',
            'Asics GT-2000',
            'Fila Spaghetti',
            'Saucony Endorphin',
            // ... répéter ou compléter jusqu'à 500 noms ...
        ];
        // Pour générer 500 noms, on boucle sur la liste
        while (count($nomsProduits) < 500) {
            $nomsProduits[] = $nomsProduits[array_rand($nomsProduits)] . ' ' . rand(1, 99);
        }

        // Génération des produits
        $nbProduits = 500;
        $nbParCategorie = intdiv($nbProduits, 3);
        $categoriesKeys = array_keys($categories);
        $typesKeys = array_keys($types);
        for ($i = 0; $i < $nbProduits; $i++) {
            $produit = new Produit();
            $produit->setRefProduit('PROD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT));
            $produit->setNomProduit($nomsProduits[$i]);
            $produit->setDescription('Description for ' . $nomsProduits[$i]);
            $produit->setPrix(mt_rand(40, 200) + (mt_rand(0, 99) / 100));
            // Répartition précise des catégories
            if ($i < $nbParCategorie) {
                $produit->setCategorie($categories['homme']);
            } elseif ($i < 2 * $nbParCategorie) {
                $produit->setCategorie($categories['femme']);
            } else {
                $produit->setCategorie($categories['enfant']);
            }
            // Répartition cyclique des types
            $produit->setType($types[$typesKeys[$i % count($typesKeys)]]);
            $manager->persist($produit);

            // Création de l'image associée
            $image = new ImageProduit();
            $image->setUrl('https://source.unsplash.com/400x400/?shoes&sig=' . ($i + 1));
            $image->setProduit($produit);
            $manager->persist($image);
        }

        $manager->flush();
    }
}
