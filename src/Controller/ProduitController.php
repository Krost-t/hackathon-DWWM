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
    #[Route('/produit', name: 'produit_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll();
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
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
                'nomProduit' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getCategorie() ? $produit->getCategorie()->getNomCategorie() : null,
                'type' => $produit->getType() ? $produit->getType()->getNomType() : null,
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
                'nomProduit' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getCategorie() ? $produit->getCategorie()->getNomCategorie() : null,
                'type' => $produit->getType() ? $produit->getType()->getNomType() : null,
                'image' => $produit->getImage() ? $produit->getImage()->getUrl() : null,
            ];
        }
        return $this->json([
            'produits' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ]);
    }
}