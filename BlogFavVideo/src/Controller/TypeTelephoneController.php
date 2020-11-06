<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;


use App\Repository\TypeTelephoneRepository;
use App\Entity\TypeTelephone;



use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Services\JwtAuth ;


class TypeTelephoneController extends AbstractController
{
    public function index()
    {
        return $this->render('type_telephone/index.html.twig', [
            'controller_name' => 'TypeTelephoneController',
        ]);
    }

    
    public function selectTypeTelephone(Request $request, JwtAuth $jwtAuth, TypeTelephoneRepository $typeTelephonerepository)
    {
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"aucun téléphone d'aucune sorte ne peut être trouvé",
            ];
        $repo_typetelephone=$typeTelephonerepository->findAll();
        $sexRepository=[];
        foreach($repo_typetelephone as $typetelephone){
            array_push($sexRepository,$typetelephone->getTypetelephone()) ;
        }
        if ($repo_typetelephone) {
            $data =[
                'status'=>'success',
                'code'=> 200,
                'typetelephone'=>$sexRepository,
                ];
              
            return  $this->json($data);
        }
    }
}