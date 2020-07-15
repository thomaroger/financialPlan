<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;


class DashboardController extends AbstractController
{

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard()
    {
        $users = [];
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findActivesUsers();
        return $this->render('dashboard/index.html.twig', ['users' => count($users)]);
    }
}
