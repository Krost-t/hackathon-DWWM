<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RetourController extends AbstractController
{
    #[Route('/retour', name: 'app_retour')]
    public function index(): Response
    {
        return $this->render('retour/index.html.twig', [
            'controller_name' => 'RetourController',
        ]);
    }
}
