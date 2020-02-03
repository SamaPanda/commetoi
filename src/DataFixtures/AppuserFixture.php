<?php

namespace App\DataFixtures;

use App\Entity\Appuser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppuserFixture extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
         $user = new Appuser();
         $user->setPassword($this->passwordEncoder->encodePassword(
                 $user,
                 'admin'
             ));
         $user->setUsername('admin');
         $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
         $manager->persist($user);
         $manager->flush();
    }
}
