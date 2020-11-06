<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;


use App\Repository\VideoStatusRepository;
use App\Entity\TypeTelephone;

class StatusVideoController extends AbstractController
{
    /**
     * @Route("/status/video", name="status_video")
     */
    public function index()
    {
        return $this->render('status_video/index.html.twig', [
            'controller_name' => 'StatusVideoController',
        ]);
    }

    public function selectVideoStatus( VideoStatusRepository $videoStatusRepository)
    { 

            $data =[
                'status'=>'error',
                'code'=> 400,
                'msg'=>"aucun status d'aucune sorte ne peut être trouvé",
                ];
            $repo_videoStatusRepository=$videoStatusRepository->findAll();
            $videoStatusRepository=[];
            foreach($repo_videoStatusRepository as $videoStatus){
                array_push($videoStatusRepository,$videoStatus->getStatus()) ;
            }
            if ($repo_videoStatusRepository) {
                $data =[
                    'status'=>'success',
                    'code'=> 200,
                    'videoStatus'=>$videoStatusRepository,
                    ];
                
                return  $this->json($data);
            }
    }
}
