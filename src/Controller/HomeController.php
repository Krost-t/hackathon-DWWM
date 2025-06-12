<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Données fictives pour la section "Nos modèles iconiques"
        $iconicProducts = [
            [
                'id' => 1,
                'name' => 'Air Force 1',
                'image' => 'air-force-1.webp', // Assurez-vous que cette image existe dans public/images
                'link' => $this->generateUrl('app_produit', ['id' => 1]),
            ],
            [
                'id' => 2,
                'name' => 'Air Max',
                'image' => 'air-max.webp', // Assurez-vous que cette image existe dans public/images
                'link' => $this->generateUrl('app_produit', ['id' => 2]),
            ],
            [
                'id' => 3,
                'name' => 'P-6000',
                'image' => 'p-6000.webp', // Assurez-vous que cette image existe dans public/images
                'link' => $this->generateUrl('app_produit', ['id' => 3]),
            ],
            // Ajoutez d'autres produits fictifs ici pour un affichage plus complet
            [
                'id' => 4,
                'name' => 'Nike Dunk',
                'image' => 'nike-dunk.webp',
                'link' => $this->generateUrl('app_produit', ['id' => 4]),
            ],
            [
                'id' => 5,
                'name' => 'Air Jordan 1',
                'image' => 'air-jordan-1.webp',
                'link' => $this->generateUrl('app_produit', ['id' => 5]),
            ],
            [
                'id' => 6,
                'name' => 'Cortez',
                'image' => 'cortez.webp',
                'link' => $this->generateUrl('app_produit', ['id' => 6]),
            ],
        ];

        return $this->render('accueil/index.html.twig', [
            'iconic_products' => $iconicProducts,
            'featured_products' => [
                [
                    'id' => 1,
                    'nom' => 'Nike Pegasus 41',
                    'image' => 'chaussure-homme-nike-pegasus-41.png',
                    'prix' => 120.00,
                    'promotion' => null,
                    'genre' => 'homme',
                    'couleur' => 'blanc',
                    'taille' => '42',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'running',
                ],
                [
                    'id' => 2,
                    'nom' => 'Nike Air Max Plus',
                    'image' => 'chaussure-homme-nike-air-max-plus.png',
                    'prix' => 180.00,
                    'promotion' => '-10%',
                    'genre' => 'homme',
                    'couleur' => 'blanc',
                    'taille' => '43',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'lifestyle',
                ],
                [
                    'id' => 3,
                    'nom' => 'Nike Air Max Dn8',
                    'image' => 'chaussure-homme-nike-air-max-dn.png',
                    'prix' => 160.00,
                    'promotion' => null,
                    'genre' => 'homme',
                    'couleur' => 'blanc',
                    'taille' => '41',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'lifestyle',
                ],
                [
                    'id' => 4,
                    'nom' => 'Nike Pegasus',
                    'image' => 'chaussure-homme-nike-pegasus-40-noir.png',
                    'prix' => 110.00,
                    'promotion' => null,
                    'genre' => 'homme',
                    'couleur' => 'vert',
                    'taille' => '44',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'running',
                ],
                [
                    'id' => 5,
                    'nom' => 'Nike Metcon',
                    'image' => 'chaussure-homme-nike-metcon-9-noir.png',
                    'prix' => 130.00,
                    'promotion' => '-5%',
                    'genre' => 'homme',
                    'couleur' => 'violet',
                    'taille' => '40',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'training',
                ],
                [
                    'id' => 6,
                    'nom' => 'Nike Air Force 1',
                    'image' => 'chaussure-homme-nike-air-force-1-07-lx-noir.png',
                    'prix' => 100.00,
                    'promotion' => null,
                    'genre' => 'homme',
                    'couleur' => 'orange',
                    'taille' => '42',
                    'type_coupe' => 'normal',
                    'lifestyle' => 'lifestyle',
                ],
            ],
        ]);
    }
}