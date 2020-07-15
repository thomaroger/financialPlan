<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('thomaroger@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             'troger'
         ));
        $user->setActive(true);
        $user->setFirstname("Thomas");
        $user->setLastname("ROGER");
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('laporte.aurelie91@gmail.com');
        $user2->setPassword($this->passwordEncoder->encodePassword(
             $user2,
             'aroger'
         ));
        $user2->setFirstname("Aurélie");
        $user2->setLastname("ROGER");
        $user2->setActive(true);
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);
        $manager->flush();
    }
}
