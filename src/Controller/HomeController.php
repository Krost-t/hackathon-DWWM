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
        ]);
    }
}