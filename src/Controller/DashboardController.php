<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Thrift;
use App\Entity\ForecastMoneyEntryInstance;
use App\Entity\ForecastMoneyExpenseInstance;


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
        $thrifts = [];
        $thrifts = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findAll();

        $forecastEntry = $this->getDoctrine()
            ->getRepository(ForecastMoneyEntryInstance::class)
            ->findByMonthAndYear(date('m'), date('Y'));

        $forecastExpense = $this->getDoctrine()
            ->getRepository(ForecastMoneyExpenseInstance::class)
            ->findByMonthAndYear(date('m'), date('Y'));

        return $this->render('dashboard/index.html.twig', 
            [
                'users' => count($users),
                'thrifts' => count($thrifts),
                'forecastEntry' => (float) $forecastEntry[0][1],
                'forecastExpense' => (float) $forecastExpense[0][1],
                'forecastDiff' => (float) $forecastEntry[0][1] - (float) $forecastExpense[0][1],
            ]
        );
    }
}
