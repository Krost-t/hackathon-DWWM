<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits_list')]
    public function list(): Response
    {
        // Données des filtres
        $filters = [
            'lifestyle' => ['Running', 'Training', 'Basketball', 'Football', 'Tennis', 'Golf', 'Yoga'],
            'genre' => ['Hommes', 'Femmes', 'Enfants'],
            'price_ranges' => ['0-50€', '50-100€', '100-150€', '150-200€', '200€+'],
            'promotions_offers' => ['Soldes', 'Nouveautés', 'Meilleures ventes', 'Offres spéciales', 'Fin de série'],
            'sizes' => ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'],
            'colors' => ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'],
            'cut_type' => ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute']
        ];

        // Simulation de données de produits avec attributs pour les filtres
        $produits = [];
        $genres = ['Hommes', 'Femmes', 'Enfants'];
        $couleurs = ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'];
        $tailles = ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'];
        $types_coupe = ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute'];
        $promotions = ['Soldes', 'Nouveautés', 'Meilleures ventes', 'Offres spéciales', 'Fin de série'];
        $lifestyles = ['Running', 'Training', 'Basketball', 'Football', 'Tennis', 'Golf', 'Yoga'];

        // Génération de 30 produits avec des variations
        for ($i = 1; $i <= 30; $i++) {
            $prix = rand(4999, 24999) / 100; // Prix entre 49.99€ et 249.99€
            $produits[] = [
                'id' => $i,
                'nom' => 'Nike ' . $lifestyles[$i % count($lifestyles)] . ' ' . rand(100, 999),
                'image' => 'product-' . ($i % 5 + 1) . '.webp', // Utilise 5 images différentes
                'prix' => $prix,
                'description_courte' => 'Chaussures de sport ' . $lifestyles[$i % count($lifestyles)] . ' pour ' . $genres[$i % count($genres)],
                'genre' => $genres[$i % count($genres)],
                'couleur' => $couleurs[$i % count($couleurs)],
                'taille' => $tailles[$i % count($tailles)],
                'type_coupe' => $types_coupe[$i % count($types_coupe)],
                'promotion' => $i % 4 === 0 ? $promotions[$i % count($promotions)] : null,
                'lifestyle' => $lifestyles[$i % count($lifestyles)]
            ];
        }

        return $this->render('produits/list.html.twig', [
            'produits' => $produits,
            'filters' => $filters
        ]);
    }
}