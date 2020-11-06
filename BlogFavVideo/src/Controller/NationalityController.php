<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;

use App\Repository\NationalityRepository;

class NationalityController extends AbstractController
{
    
    public function index()
    {
        return $this->render('nationality/index.html.twig', [
            'controller_name' => 'NationalityController',
        ]);
    }

    public function selectNationality( NationalityRepository $nationaliteRepository)
    {
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"aucun Nationalité d'aucune sorte ne peut être trouvé",
            ];
        $repo_nationaliteRepository=$nationaliteRepository->findAll();
        $nationaliteRepository=[];
        foreach($repo_nationaliteRepository as $nationalite){
            array_push($nationaliteRepository,$nationalite->getNationality()) ;
        }
        if ($repo_nationaliteRepository) {
            $data =[
                'status'=>'success',
                'code'=> 200,
                'nationality'=>$nationaliteRepository,
                ];
              
            return  $this->json($data);
        }
    }
}
