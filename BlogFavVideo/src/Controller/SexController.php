<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;

use App\Repository\SexRepository;

class SexController extends AbstractController
{
    
    public function index()
    {
        return $this->render('sex/index.html.twig', [
            'controller_name' => 'SexController',
        ]);
    }

    public function selectSex( SexRepository $sexRepository)
    {
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"aucun sex d'aucune sorte ne peut être trouvé",
            ];
        $repo_sexRepository=$sexRepository->findAll();
        $sexRepository=[];
        foreach($repo_sexRepository as $sex){
            array_push($sexRepository,$sex->getSex()) ;
        }
        if ($repo_sexRepository) {
            $data =[
                'status'=>'success',
                'code'=> 200,
                'sex'=>$sexRepository,
                ];
              
            return  $this->json($data);
        }
    }
}
