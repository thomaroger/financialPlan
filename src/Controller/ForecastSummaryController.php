<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ForecastMoneyExpenseInstance;
use App\Entity\ForecastMoneyEntryInstance;
use App\Entity\Thrift;

class ForecastSummaryController extends AbstractController
{
    /**
     * @Route("/forecast/summary", name="app_forecast_summary")
     */
    public function index()
    {
        $request = Request::createFromGlobals();

        $monthsWithYear = [];
        $months = [];
        $year = date('y');
        $yearSelected = date('Y');
        $expenses = [];
        $count = [];
        $entries = [];
        $diffs = [];
        $thrifts = [];
        $availableThrifts = [];
        $lastthrift = 0;
        $lastavailablethrifts= 0;
        
        if(!empty($request->query->get('year'))) {
            $yearSelected = $request->query->get('year');
        }

        $thriftsInDatabase = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findAll();

        foreach ($thriftsInDatabase as $thriftInDatabase) {
            if($thriftInDatabase->getAvailable()) {
                $lastavailablethrifts += $thriftInDatabase->getBalance();
            }
            $lastthrift += $thriftInDatabase->getBalance();

        }   

        setlocale(LC_TIME, 'fr_FR');
        for($y=2020; $y<=2029; $y++){
            $years[$y] = $y;
            for($i=1; $i<=12; $i++){
                $monthsWithYear[$y][$i] = ucfirst(strftime("%b", mktime(0, 0, 0, $i, 1, $y)));
                $months[$y][$i] = ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, $y)));
                $expenses[$y][$i] = 0;
                $entries[$y][$i] = 0;
                $expenseByMonth = $this->getDoctrine()
                    ->getRepository(ForecastMoneyExpenseInstance::class)
                    ->findByMonthAndYear($i, $y);
                if(!empty($expenseByMonth[0][1])) {
                    $expenses[$y][$i] = $expenseByMonth[0][1];
                }
                $entryByMonth = $this->getDoctrine()
                    ->getRepository(ForecastMoneyEntryInstance::class)
                    ->findByMonthAndYear($i, $y);
                if(!empty($entryByMonth[0][1])) {
                    $entries[$y][$i] = $entryByMonth[0][1];
                }
                $diffs[$y][$i] = $entries[$y][$i] - $expenses[$y][$i];
                $thrifts[$y][$i] = $lastthrift + $diffs[$y][$i];
                $lastthrift = $thrifts[$y][$i];
                $availableThrifts[$y][$i] = $lastavailablethrifts + $diffs[$y][$i];
                $lastavailablethrifts = $availableThrifts[$y][$i];
            }
        }

        return $this->render('forecast_summary/index.html.twig', [
            'monthsWithYear' => $monthsWithYear,
             'months' => $months,
             'yearSelected' => $yearSelected,
             'years' => $years,
             'expenses' => $expenses,
             'entries' => $entries,
             'diffs' => $diffs,
             'thrifts' => $thrifts,
             'availableThrifts' => $availableThrifts
        ]);
    }
}
