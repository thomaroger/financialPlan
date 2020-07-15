<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="app_user")
     */
    public function index()
    {
        $users = [];
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/user/toogle/{id}", name="app_user_toogle")
     */
    public function toogle($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByID($id);

        if(empty($user)) {
            return $this->redirectToRoute('app_user');
        }   

        $active = true;
        if($user->isActive() === true) {
            $active = false;
        }
        $user->setActive($active);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_user');
    }

    /**
     * @Route("/user/add", name="app_user_add")
     */
    public function add(UserPasswordEncoderInterface $encoder)
    {
        $request = Request::createFromGlobals();
        $datas = $request->request->all();
        $active = false;
        if (empty($datas['email']) || empty($datas['password']) || empty($datas['firstname']) || empty($datas['lastname'])) {
            return $this->redirectToRoute('app_user');
        }
        if(!empty($datas['active'])) {
            $active = true;
        }

        $user = new User();
        $user->setEmail($datas['email']);
        $user->setPassword($encoder->encodePassword(
             $user,
             $datas['password']
         ));

        $user->setActive($active);
        $user->setFirstname($datas['firstname']);
        $user->setLastname($datas['lastname']);
        $user->setRoles(['ROLE_USER']);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        
        return $this->redirectToRoute('app_user');
    }
}
