<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'iconic_products' => [
                [
                    'name' => 'Nike Air Force 1',
                    'image' => 'chaussure-homme-nike-air-force-1-07-lx-noir.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Dunk Low',
                    'image' => 'chaussure-homme-nike-dunk-low-retro-blanc-noir.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Blazer Mid 77',
                    'image' => 'chaussure-homme-nike-blazer-mid-77-vintage-blanc-noir.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Air Max 90',
                    'image' => 'chaussure-homme-nike-air-max-90-noir-blanc.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Air Jordan 1',
                    'image' => 'chaussure-homme-air-jordan-1-mid-gris.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Metcon',
                    'image' => 'chaussure-homme-nike-metcon-9-noir.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike Pegasus',
                    'image' => 'chaussure-homme-nike-pegasus-40-noir.png',
                    'link' => '#'
                ],
                [
                    'name' => 'Nike ZoomX Invincible Run',
                    'image' => 'chaussure-homme-nike-zoomx-invincible-run-flyknit-3-blanc.png',
                    'link' => '#'
                ],
            ],
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