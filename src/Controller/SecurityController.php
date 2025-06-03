<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $session = $request->getSession();
        $clientIp = $request->getClientIp();
        $attemptKey = 'login_attempts_' . md5($clientIp);
        $blockKey = 'login_blocked_until_' . md5($clientIp);
        
        // Vérifier si l'utilisateur est bloqué
        $blockedUntil = $session->get($blockKey);
        if ($blockedUntil && time() < $blockedUntil) {
            $remainingTime = $blockedUntil - time();
            $minutes = ceil($remainingTime / 60);
            $this->addFlash('error', "Trop de tentatives de connexion. Réessayez dans {$minutes} minute(s).");
            return $this->render('login/login.html.twig', [
                'last_username' => '',
                'error' => null,
                'blocked' => true,
                'remaining_minutes' => $minutes
            ]);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Incrémenter le compteur de tentatives en cas d'erreur
        if ($error) {
            $attempts = $session->get($attemptKey, 0) + 1;
            $session->set($attemptKey, $attempts);
            
            // Bloquer après 5 tentatives pour 15 minutes
            if ($attempts >= 5) {
                $blockUntil = time() + (15 * 60); // 15 minutes
                $session->set($blockKey, $blockUntil);
                $session->remove($attemptKey);
                
                $this->addFlash('error', 'Trop de tentatives de connexion échouées. Compte bloqué pendant 15 minutes.');
                return $this->render('login/login.html.twig', [
                    'last_username' => '',
                    'error' => null,
                    'blocked' => true,
                    'remaining_minutes' => 15
                ]);
            }
            
            $remainingAttempts = 5 - $attempts;
            $this->addFlash('warning', "Tentative échouée. {$remainingAttempts} tentative(s) restante(s) avant blocage.");
        } else {
            // Réinitialiser le compteur en cas de succès (pas d'erreur)
            $session->remove($attemptKey);
            $session->remove($blockKey);
        }

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'blocked' => false
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
