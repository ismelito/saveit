<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Video;
use App\Entity\Url;
use App\Entity\VideoStatus;
use App\Repository\VideoRepository;
use App\Repository\UrlRepository;
use App\Repository\VideoStatusRepository;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $idVideoStatus=0;
        $idUrl=0;
        //creation des url et des marital status
        for($j=0;$j<10;$j++){
            $url=new Url();
            $url->setUrl("url-$j");
            $videostatus=new VideoStatus();
            $videostatus->setStatus("status-$j");
            $manager->persist($url);
            $manager->persist($videostatus);
            if($j==8){
                $idUrl=$j;
            }    
            if($j==9){
                $idVideoStatus=$j;
            }         
        }
        //Insertion on Bd des 10 urls et 10 marital status
        $manager->flush();  

        //creation deun video
        $video=new Video();
        $video->setTitle("video-1");
        $video->setDescription("description-1");
        $video->setIdUrl($idUrl);//$objUrl->getId()
        $video->setIdVideoStatus($idVideoStatus);//$objVideostatus->getId()
        $video->setCreateAt(new \DateTime('now'));
        $video->setUpdateAt(new \DateTime('now'));
        $manager->persist($video);       
        //Insertion on Bd de un video
        $manager->flush();
    }
}
