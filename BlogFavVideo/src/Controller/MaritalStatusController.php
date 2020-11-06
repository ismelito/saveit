<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;

use App\Repository\MaritalStatusRepository;

class MaritalStatusController extends AbstractController
{
    
    public function index()
    {
        return $this->render('marital_status/index.html.twig', [
            'controller_name' => 'MaritalStatusController',
        ]);
    }

    public function selectMaritalStatus( MaritalStatusRepository $maritalStatusRepository)
    {
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"aucun marital Status d'aucune sorte ne peut être trouvé",
            ];
        $repo_maritalStatusRepository=$maritalStatusRepository->findAll();
        $maritalStatusRepository=[];
        foreach($repo_maritalStatusRepository as $maritalStatus){
            array_push($maritalStatusRepository,$maritalStatus->getMaritalStatus()) ;
        }

        if ($repo_maritalStatusRepository) {
            $data =[
                'status'=>'success',
                'code'=> 200,
                'maritalStatus'=>$maritalStatusRepository,
                ];
              
            return  $this->json($data);
        }
    }
}
