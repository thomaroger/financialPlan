<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\ForecastMoneyEntry;
use App\Entity\ForecastMoneyEntryInstance;


class ForecastMoneyEntryController extends AbstractController
{
    /**
     * @Route("/forecast/money/entry", name="app_money_entry")
     */
    public function index()
    {
        $request = Request::createFromGlobals();

        $users = [];
        $monthsWithYear = [];
        $months = [];
        $year = date('y');
        $yearSelected = date('Y');
        $entries = [];
        $count = [];

        if(!empty($request->query->get('year'))) {
            $yearSelected = $request->query->get('year');
        }

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findActivesUsers();
        
        setlocale(LC_TIME, 'fr_FR');
        for($i=1; $i<=12; $i++){
          $monthsWithYear[$i] = ucfirst(strftime("%b", mktime(0, 0, 0, $i, 1, $year)));
          $months[$i] = ucfirst(strftime("%B", mktime(0, 0, 0, $i, 1,$year)));
        }

        for($i=0; $i<=3; $i++){
          $years[$i] = date('Y')+$i;
        }

        $forecastMoneyEntryInstances = $this->getDoctrine()
            ->getRepository(ForecastMoneyEntryInstance::class)
            ->findAll();

        foreach ($forecastMoneyEntryInstances as $forecastMoneyEntryInstance) {
            $entries[$forecastMoneyEntryInstance->getForecastMoneyEntry()->getID()][$forecastMoneyEntryInstance->getYear()][$forecastMoneyEntryInstance->getMonth()] = $forecastMoneyEntryInstance->getPrice();
            $entries[$forecastMoneyEntryInstance->getForecastMoneyEntry()->getID()]['name'] = $forecastMoneyEntryInstance->getForecastMoneyEntry()->getName();

            if (empty($count[$forecastMoneyEntryInstance->getYear()][$forecastMoneyEntryInstance->getMonth()])) {
                $count[$forecastMoneyEntryInstance->getYear()][$forecastMoneyEntryInstance->getMonth()] = 0;
            }
            $count[$forecastMoneyEntryInstance->getYear()][$forecastMoneyEntryInstance->getMonth()] += $forecastMoneyEntryInstance->getPrice();
        }

        return $this->render('money_entry/index.html.twig', [
             'users' => $users,
             'monthsWithYear' => $monthsWithYear,
             'months' => $months,
             'yearSelected' => $yearSelected,
             'years' => $years,
             'entries' => $entries,
             'count' => $count,
        ]);
    }

     /**
     * @Route("/forecast/money/entry/add", name="app_money_entry_add")
     */
    public function add()
    {
        $request = Request::createFromGlobals();
        $datas = $request->request->all();
        $recurrent = 0;
        if (empty($datas['name']) || empty($datas['user']) || empty($datas['price'])) {
            return $this->redirectToRoute('app_money_entry');
        }

        if(!empty($datas['recurrent'])) {
            $recurrent = true;
            if (empty($datas['begin_month']) || empty($datas['begin_year'])) {
                return $this->redirectToRoute('app_money_entry');
            }
            $month = (int) $datas['begin_month'];
            $year = (int) $datas['begin_year'];
        } else {
             if ( empty($datas['month']) || empty($datas['year'])) {
                return $this->redirectToRoute('app_money_entry');
            }
            $month = (int) $datas['month'];
            $year = (int) $datas['year'];
        }
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByID($datas['user']);

        if(empty($user)) {
            return $this->redirectToRoute('app_money_entry');
        }  

        $forecastMoneyEntry = new ForecastMoneyEntry();
        $forecastMoneyEntry->setName($datas['name']);
        $forecastMoneyEntry->setUser($user);
        $forecastMoneyEntry->setPrice($datas['price']);
        $forecastMoneyEntry->setRecurrent($recurrent);
        $forecastMoneyEntry->setDate(\DateTime::createFromFormat('d-m-Y', '01-'.$month.'-'.$year));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($forecastMoneyEntry);
        $manager->flush();

        if ($recurrent === true) {
            $y = $year;
            for($y; $y <= 2029; $y++) {
                $m = $month;
                if($y>$year){
                    $m = 0;
                }
                for($m; $m <= 12; $m++) {
                    $forecastMoneyEntryInstance = new ForecastMoneyEntryInstance();
                    $forecastMoneyEntryInstance->setPrice($datas['price']);
                    $forecastMoneyEntryInstance->setForecastMoneyEntry($forecastMoneyEntry);
                    $forecastMoneyEntryInstance->setMonth($m);
                    $forecastMoneyEntryInstance->setYear($y);

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($forecastMoneyEntryInstance);
                    $manager->flush();
                }
            }
        } else {

            $forecastMoneyEntryInstance = new ForecastMoneyEntryInstance();
            $forecastMoneyEntryInstance->setPrice($datas['price']);
            $forecastMoneyEntryInstance->setForecastMoneyEntry($forecastMoneyEntry);
            $forecastMoneyEntryInstance->setMonth($month);
            $forecastMoneyEntryInstance->setYear($year);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($forecastMoneyEntryInstance);
            $manager->flush();
        }
        
        return $this->redirectToRoute('app_money_entry');

    }
}
