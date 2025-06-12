<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    #[Route('/produits', name: 'produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        $data = [];
        foreach ($produits as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'refProduit' => $produit->getRefProduit(),
                'nom' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getCategorie() ? $produit->getCategorie()->getNomCategorie() : null,
                'type' => $produit->getType() ? $produit->getType()->getNomType() : null,
                'image' => $produit->getImage() ? $produit->getImage()->getUrl() : null,
                'genre' => $this->getGenreForProduct($produit->getId()),
                'couleur' => $this->getColorForProduct($produit->getId()),
                'taille' => $this->getSizeForProduct($produit->getId()),
                'type_coupe' => $this->getCutTypeForProduct($produit->getId()),
                'lifestyle' => $this->getLifestyleForProduct($produit->getId()),
                'promotion' => $produit->getId() % 4 === 0 ? 'Solde' : null,
            ];
        }
        return $this->render('produit/index.html.twig', [
            'produits' => $data,
            'filters' => $this->getFiltersData()
        ]);
    }

    private function getGenreForProduct(int $id): string
    {
        $genres = ['Hommes', 'Femmes', 'Enfants'];
        return $genres[$id % count($genres)];
    }

    private function getColorForProduct(int $id): string
    {
        $couleurs = ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'];
        return $couleurs[$id % count($couleurs)];
    }

    private function getSizeForProduct(int $id): string
    {
        $tailles = ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'];
        return $tailles[$id % count($tailles)];
    }

    private function getCutTypeForProduct(int $id): string
    {
        $types_coupe = ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute'];
        return $types_coupe[$id % count($types_coupe)];
    }

    private function getLifestyleForProduct(int $id): string
    {
        $lifestyles = ['Jordan', 'Running', 'Basketball', 'Football', 'Training et fitness', 'Skateboard', 'Golf', 'Tennis', 'Marche à pied'];
        return $lifestyles[$id % count($lifestyles)];
    }

    private function getFiltersData(): array
    {
        return [
            'lifestyle' => ['Jordan', 'Running', 'Basketball', 'Football', 'Training et fitness', 'Skateboard', 'Golf', 'Tennis', 'Marche à pied'],
            'genre' => ['Hommes', 'Femmes', 'Enfants'],
            'price_ranges' => ['0-50€', '50-100€', '100-150€', '150-200€', '200€+'],
            'promotions_offers' => ['Soldes', 'Nouveautés', 'Meilleures ventes', 'Offres spéciales', 'Fin de série'],
            'sizes' => ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'],
            'colors' => ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'],
            'cut_type' => ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute']
        ];
    }

    #[Route('/produit/json', name: 'produit_json')]
    public function produitsJson(ProduitRepository $produitRepository): JsonResponse
    {
        $produits = $produitRepository->findAll();
        $data = [];
        foreach ($produits as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'refProduit' => $produit->getRefProduit(),
                'nom' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getCategorie() ? $produit->getCategorie()->getNomCategorie() : null,
                'type' => $produit->getType() ? $produit->getType()->getNomType() : null,
                'image' => $produit->getImage() ? $produit->getImage()->getUrl() : null,
                'genre' => $this->getGenreForProduct($produit->getId()),
                'couleur' => $this->getColorForProduct($produit->getId()),
                'taille' => $this->getSizeForProduct($produit->getId()),
                'type_coupe' => $this->getCutTypeForProduct($produit->getId()),
                'lifestyle' => $this->getLifestyleForProduct($produit->getId()),
                'promotion' => $produit->getId() % 4 === 0 ? 'Solde' : null,
            ];
        }
        return $this->json($data);
    }

    #[Route('/produit/ajax', name: 'produit_ajax', methods: ['GET'])]
    public function ajaxProduits(ProduitRepository $produitRepository): JsonResponse
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $genres = $request->query->all('genre');
        $types = $request->query->all('type');
        $prix = $request->query->all('prix');
        $nom = $request->query->get('nom');

        $qb = $produitRepository->createQueryBuilder('p')
            ->leftJoin('p.categorie', 'c')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.image', 'img')
            ->addSelect('c', 't', 'img');

        if (!empty($genres)) {
            $qb->andWhere('c.nomCategorie IN (:genres)')->setParameter('genres', $genres);
        }
        if (!empty($types)) {
            $qb->andWhere('t.nomType IN (:types)')->setParameter('types', $types);
        }
        if (!empty($prix)) {
            $orX = $qb->expr()->orX();
            foreach ($prix as $p) {
                if ($p === '-50')
                    $orX->add('p.prix < 50');
                if ($p === '50-100')
                    $orX->add('p.prix >= 50 AND p.prix < 100');
                if ($p === '100-150')
                    $orX->add('p.prix >= 100 AND p.prix < 150');
                if ($p === '150+')
                    $orX->add('p.prix >= 150');
            }
            $qb->andWhere($orX);
        }
        if ($nom) {
            $qb->andWhere('LOWER(p.nomProduit) LIKE :nom')->setParameter('nom', '%' . strtolower($nom) . '%');
        }

        // Clone pour le total
        $qbCount = clone $qb;
        $qb->setFirstResult($offset)->setMaxResults($limit);
        $produits = $qb->getQuery()->getResult();
        $total = (int) $qbCount->select('COUNT(p.id)')->getQuery()->getSingleScalarResult();

        $data = [];
        foreach ($produits as $produit) {
            $data[] = [
                'id' => $produit->getId(),
                'refProduit' => $produit->getRefProduit(),
                'nom' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getCategorie() ? $produit->getCategorie()->getNomCategorie() : null,
                'type' => $produit->getType() ? $produit->getType()->getNomType() : null,
                'image' => $produit->getImage() ? $produit->getImage()->getUrl() : null,
                'genre' => $this->getGenreForProduct($produit->getId()),
                'couleur' => $this->getColorForProduct($produit->getId()),
                'taille' => $this->getSizeForProduct($produit->getId()),
                'type_coupe' => $this->getCutTypeForProduct($produit->getId()),
                'lifestyle' => $this->getLifestyleForProduct($produit->getId()),
                'promotion' => $produit->getId() % 4 === 0 ? 'Solde' : null,
            ];
        }
        return $this->json([
            'produits' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit')]
    public function show(int $id): Response
    {
        // Données des filtres
        $filters = [
            'lifestyle' => ['Jordan', 'Running', 'Basketball', 'Football', 'Training et fitness', 'Skateboard', 'Golf', 'Tennis', 'Marche à pied'],
            'genre' => ['Hommes', 'Femmes', 'Enfants'],
            'price_ranges' => ['0-50€', '50-100€', '100-150€', '150-200€', '200€+'],
            'promotions_offers' => ['Soldes', 'Nouveautés', 'Meilleures ventes', 'Offres spéciales', 'Fin de série'],
            'sizes' => ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'],
            'colors' => ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'],
            'cut_type' => ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute']
        ];

        // Simulation de données de produits avec attributs pour les filtres
        $genres = ['Hommes', 'Femmes', 'Enfants'];
        $couleurs = ['Noir', 'Blanc', 'Rouge', 'Bleu', 'Vert', 'Gris', 'Jaune', 'Rose', 'Orange', 'Violet', 'Marron', 'Beige'];
        $tailles = ['36', '36.5', '37', '37.5', '38', '38.5', '39', '39.5', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44', '44.5', '45', '45.5', '46'];
        $types_coupe = ['Basse', 'Moyenne', 'Haute', 'Ultra-basse', 'Ultra-haute'];
        $promotions = ['Soldes', 'Nouveautés', 'Meilleures ventes', 'Offres spéciales', 'Fin de série'];
        $lifestyles = ['Jordan', 'Running', 'Basketball', 'Football', 'Training et fitness', 'Skateboard', 'Golf', 'Tennis', 'Marche à pied'];

        // Génération du produit avec l'ID spécifié
        $prix = rand(4999, 24999) / 100; // Prix entre 49.99€ et 249.99€
        $produit = [
            'id' => $id,
            'nom' => 'Nike ' . $lifestyles[$id % count($lifestyles)] . ' ' . rand(100, 999),
            'image' => 'product-' . ($id % 5 + 1) . '.webp', // Utilise 5 images différentes
            'prix' => $prix,
            'description' => 'Description détaillée des chaussures de sport ' . $lifestyles[$id % count($lifestyles)] . ' pour ' . $genres[$id % count($genres)] . '. Ces chaussures offrent un excellent confort et une performance optimale pour vos activités sportives.',
            'genre' => $genres[$id % count($genres)],
            'couleur' => $couleurs[$id % count($couleurs)],
            'taille' => $tailles[$id % count($tailles)],
            'type_coupe' => $types_coupe[$id % count($types_coupe)],
            'promotion' => $id % 4 === 0 ? $promotions[$id % count($promotions)] : null,
            'lifestyle' => $lifestyles[$id % count($lifestyles)]
        ];

        // Récupération des images depuis le dossier public/images
        $images = [];
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/images';

        if (is_dir($imagePath)) {
            $files = scandir($imagePath);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = $file;
                }
            }
        }

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
            'images' => $images,
            'filters' => $filters
        ]);
    }
}