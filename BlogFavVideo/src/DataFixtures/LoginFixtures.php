<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Login;
use App\Repository\LoginRepository;
use Doctrine\ORM\EntityManagerInterface;

class LoginFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for($i=0; $i<10; $i++){
          $login= new Login();
          $login->setEmail("emai$i@gmail.com");
          $login->setPassword("i$0000");
          $manager->persist($login);
        }        
        $manager->flush();
        $repo_login=$manager->getRepository(login::class);
        $login=$repo_login->findOneBy(['email'=> "emai1@gmail.com"]);
        $manager->remove($login);
        $manager->flush();
        
    }

    public function loadMofid(ObjectManager $manager)
    {

        for($i=0; $i<10; $i++){
          $login= new Login();
          $login->setEmail("emai$i@gmail.com");
          $login->setPassword("$i$0000");
          $manager->persist($login);
        }        
        $manager->flush();
    }
}