<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Thrift;
use App\Entity\ForecastMoneyExpense;
use App\Entity\ForecastMoneyExpenseInstance;

class ForecastMoneyExpensesController extends AbstractController
{
    /**
     * @Route("/forecast/money/expenses", name="app_expenses")
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

        
        if(!empty($request->query->get('year'))) {
            $yearSelected = $request->query->get('year');
        }

        setlocale(LC_TIME, 'fr_FR');
        for($i=1; $i<=12; $i++){
          $monthsWithYear[$i] = ucfirst(strftime("%b", mktime(0, 0, 0, $i, 1, $year)));
          $months[$i] = ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1, $year)));
        }

        for($i=0; $i<=3; $i++){
          $years[$i] = date('Y')+$i;
        }

        $forecastMoneyExpenseInstances = $this->getDoctrine()
            ->getRepository(ForecastMoneyExpenseInstance::class)
            ->findAll();

        foreach ($forecastMoneyExpenseInstances as $forecastMoneyExpenseInstance) {
            $expenses[$forecastMoneyExpenseInstance->getForecastMoneyExpense()->getID()][$forecastMoneyExpenseInstance->getYear()][$forecastMoneyExpenseInstance->getMonth()] = $forecastMoneyExpenseInstance->getPrice();
            $expenses[$forecastMoneyExpenseInstance->getForecastMoneyExpense()->getID()]['name'] = $forecastMoneyExpenseInstance->getForecastMoneyExpense()->getName();

            if (empty($count[$forecastMoneyExpenseInstance->getYear()][$forecastMoneyExpenseInstance->getMonth()])) {
                $count[$forecastMoneyExpenseInstance->getYear()][$forecastMoneyExpenseInstance->getMonth()] = 0;
            }
            $count[$forecastMoneyExpenseInstance->getYear()][$forecastMoneyExpenseInstance->getMonth()] += $forecastMoneyExpenseInstance->getPrice();
        }

         $thriftsNotAvailable = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findBy(array('available' => false));

        

        return $this->render('money_expenses/index.html.twig', [
             'monthsWithYear' => $monthsWithYear,
             'months' => $months,
             'yearSelected' => $yearSelected,
             'years' => $years,
             'expenses' => $expenses,
             'count' => $count,
             'thriftsNotAvailable' => $thriftsNotAvailable
        ]);
    }


    /**
     * @Route("/forecast/money/expenses/add", name="app_expenses_add")
     */
    public function add()
    {
        $request = Request::createFromGlobals();
        $datas = $request->request->all();
        $recurrent = 0;
        if (empty($datas['name']) || empty($datas['price'])) {
            return $this->redirectToRoute('app_expenses');
        }

        if(!empty($datas['recurrent'])) {
            $recurrent = true;
            if (empty($datas['begin_month']) || empty($datas['begin_year'])) {
                return $this->redirectToRoute('app_expenses');
            }
            $month = (int) $datas['begin_month'];
            $year = (int) $datas['begin_year'];
        } else {
             if ( empty($datas['month']) || empty($datas['year'])) {
                return $this->redirectToRoute('app_expenses');
            }
            $month = (int) $datas['month'];
            $year = (int) $datas['year'];
        }

        $forecastMoneyExpense = new ForecastMoneyExpense();
        $forecastMoneyExpense->setName($datas['name']);
        $forecastMoneyExpense->setPrice($datas['price']);
        $forecastMoneyExpense->setRecurrent($recurrent);
        $forecastMoneyExpense->setDate(\DateTime::createFromFormat('d-m-Y', '01-'.$month.'-'.$year));

        if(!empty($datas['thriftsNotAvailable'])) {
            $thriftNotAvailable = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findOneByID($datas['thriftsNotAvailable']);
            $forecastMoneyExpense->setThrift($thriftNotAvailable);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($forecastMoneyExpense);
        $manager->flush();

        if ($recurrent === true) {
            $y = $year;
            for($y; $y <= 2029; $y++) {
                $m = $month;
                if($y>$year){
                    $m = 0;
                }
                for($m; $m <= 12; $m++) {
                    $forecastMoneyExpenseInstance = new ForecastMoneyExpenseInstance();
                    $forecastMoneyExpenseInstance->setPrice($datas['price']);
                    $forecastMoneyExpenseInstance->setForecastMoneyExpense($forecastMoneyExpense);
                    $forecastMoneyExpenseInstance->setMonth($m);
                    $forecastMoneyExpenseInstance->setYear($y);

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($forecastMoneyExpenseInstance);
                    $manager->flush();
                }
            }
        } else {

            $forecastMoneyExpenseInstance = new ForecastMoneyExpenseInstance();
            $forecastMoneyExpenseInstance->setPrice($datas['price']);
            $forecastMoneyExpenseInstance->setForecastMoneyExpense($forecastMoneyExpense);
            $forecastMoneyExpenseInstance->setMonth($month);
            $forecastMoneyExpenseInstance->setYear($year);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($forecastMoneyExpenseInstance);
            $manager->flush();
        }
        
        return $this->redirectToRoute('app_expenses');

    }


    /**
     * @Route("/forecast/money/expenses/{id}/delete", name="app_expense_delete")
     */
    public function delete($id)
    {
        $forecastMoneyExpenseInstances = [];

        $expense =$this->getDoctrine()
            ->getRepository(ForecastMoneyExpense::class)
            ->findOneByID($id);

        $forecastMoneyExpenseInstances =$this->getDoctrine()
            ->getRepository(ForecastMoneyExpenseInstance::class)
            ->findByForecastMoneyExpense($id);

        $manager = $this->getDoctrine()->getManager();
        foreach ($forecastMoneyExpenseInstances as $forecastMoneyExpenseInstance) {
            $manager->remove($forecastMoneyExpenseInstance);
            $manager->flush();
        }
        $manager->remove($expense);
        $manager->flush();

        return $this->redirectToRoute('app_expenses');
    }
}
