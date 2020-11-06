<?php

namespace App\Tests\Repository;

use App\Repository\VideoRepository;
use App\Repository\UrlRepository;
use App\Repository\VideoStatusRepository;
use Monolog\Test\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VideorepositoryTest extends KernelTestCase{

   

    public function testCountVideo(){

        self::bootKernel();// demarre le kernel pour recuperer le noyaux
        $video=self::$container->get(VideoRepository::class)->count([]);  
        $url=self::$container->get(UrlRepository::class)->count([]); 
        $videostatus=self::$container->get(VideoStatusRepository::class)->count([]);  
        $this->assertEquals(1,$video);
        $this->assertEquals(10,$url);       
        $this->assertEquals(10,$videostatus);     
    }



}