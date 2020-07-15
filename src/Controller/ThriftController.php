<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Thrift;

class ThriftController extends AbstractController
{
    /**
     * @Route("/thrift", name="app_thrift")
     */
    public function index()
    {
        $users = [];
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findActivesUsers();
        $thrifts = [];
        $thrifts = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findAll();

        $sumRatio = 0;
        foreach ($thrifts as $thrift) {
            if($thrift->getAvailable()) {
                $sumRatio += $thrift->getRatio();
            }
        }
        return $this->render('thrift/index.html.twig', [
            'users' => $users,
            'thrifts' => $thrifts,
            'sumRatio' => $sumRatio,
        ]);
    }

    /**
     * @Route("/thrift/add", name="app_thrift_add")
     */
    public function add()
    {
        $request = Request::createFromGlobals();
        $datas = $request->request->all();
        $available = false;
        $ratio = 0;
        if (empty($datas['name']) || empty($datas['bank']) || empty($datas['user']) || empty($datas['balance'])) {
            return $this->redirectToRoute('app_thrift');
        }
        if(!empty($datas['available'])) {
            $available = true;
            $ratio = (int) $datas['ratio'];
        }


        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByID($datas['user']);

        if(empty($user)) {
            return $this->redirectToRoute('app_thrift');
        }  

        $thrift = new Thrift();
        $thrift->setName($datas['name']);
        $thrift->setBank($datas['bank']);
        $thrift->setUser($user);
        $thrift->setBalance($datas['balance']);
        $thrift->setRatio($ratio);
        $thrift->setAvailable($available);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($thrift);
        $manager->flush();
        
        return $this->redirectToRoute('app_thrift');

    }

    /**
     * @Route("/thrift/edit/{id}", name="app_thrift_edit")
     */
    public function edit($id)
    {
        $request = Request::createFromGlobals();
        $datas = $request->request->all();
        $ratio = 0;

        $thrift = $this->getDoctrine()
            ->getRepository(Thrift::class)
            ->findOneByID($id);

        if(empty($thrift)) {
            return $this->redirectToRoute('app_thrift');
        }   

        $ratio = (int) $datas['ratio'];

        $thrift->setRatio($ratio);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($thrift);
        $manager->flush();

        return $this->redirectToRoute('app_thrift');
    }
}
