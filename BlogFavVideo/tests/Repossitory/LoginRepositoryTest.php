<?php

namespace App\Tests\Repository;

use App\Repository\LoginRepository;
use App\Entity\Login;
use Doctrine\Persistence\ObjectManager;

use Monolog\Test\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoginrepositoryTest extends KernelTestCase{

    public function testCountLoginBD(){

        self::bootKernel();
        $login=self::$container->get(LoginRepository::class)->count([]);   
        $this->assertEquals(0,$login);
    }
    public function testInsertLogin(){
        
        
            $login= new Login();
            $login->setEmail("emai1@gmail.com");
            $login->setPassword("i$0000");
            
            $this->assertEquals("emai1@gmail.com",$login->getEmail());
            $this->assertEquals("i$0000",$login->getPassword());  
    }
    public function testValidationEntity(){
        
        
        $login= new Login();        
        $login->setEmail("memai1@gmail.com");
        $login->setPassword("");
        self::bootKernel();
        $error=self::$container->get('validator')->validate($login)->count([]);
        
        $this->assertEquals(0 , $error);  
     
  
}

    
}