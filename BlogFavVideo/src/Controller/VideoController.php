<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


use App\Services\JwtAuth ;
use App\Repository\UserRepository;
use App\Repository\UserVideoRepository;
use App\Repository\VideoRepository;
use App\Repository\UrlRepository;
use App\Repository\VideoStatusRepository;

use App\Entity\Video;
use App\Entity\Url;
use App\Entity\VideoStatus;
use App\Entity\UserVideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Knp\Component\Pager\PaginatorInterface;


class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function index()
    {
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }

    /**
     * Creation d'un video
     * 
     * @param Request $request
     * @param JwtAuth $jwtAuth
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     * @param VideoRepository $videoRepository
     * @param UrlRepository $urlRepository
     * @param UserVideoRepository $userVideoRepository
     * @param VideoStatusRepository $videoStatusRepository
     * @return void
     */
    public function createVideo(
        Request $request, 
        JwtAuth $jwtAuth,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        VideoRepository $videoRepository,
        UrlRepository $urlRepository,
        UserVideoRepository $userVideoRepository,
        VideoStatusRepository $videoStatusRepository
         ){
        
        
        $token=$request->headers->get('Authorization');
       
        $authtoken=$jwtAuth->checkToken($token);
            
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"création de vidéo incorrecte",
            ];
         
           if ($authtoken) {
              $json=$request->get('json',null); 
              try{
                if ( $json!=null ) {  // $request->getContent()
                  $params= json_decode($json);  //  $params=json_decode($request->getContent());
                   
                   
                   
                    $identity=$jwtAuth->checkToken($token,true);

                    //recuperation id de l'utilisateur
                    $user_id=!empty($identity->sub) ? $identity->sub:null;
                  
                    //recuperacion des donnes envoie par l'interface
                    $title =(!empty($params->title)) ? $params->title:null;
                    $description =(!empty($params->description)) ? $params->description:null;
                    $url =(!empty($params->url)) ? $params->url:null;
                    $status =(!empty($params->statusVideo)) ? $params->statusVideo:null;
                    
                    if (!empty($user_id) && !empty($title) && !empty($description) &&  !empty($url) && !empty($status)) {
                        
                        //creation d'un objet Url
                        $urlObj= new Url();
                        $urlObj->setUrl($url);

                         $errors=$validator->validate($urlObj);

                        if (count($errors)) { //verifie le type de champs envoie depuis l'interface
                            $errorsString = (string) $errors;
                            return new Response($errorsString);
                        }else{

                           
                            $isset_url=$urlRepository->findBy(['url'=>$url]);
                            if(empty($isset_url)){
                                                              //insérer dans la base de données l'url et le statut
                                $em->persist($urlObj);
                                $em->flush();
                                //creation d'un objet video
                                $video= new Video();
                                $video->setTitle($title);
                                $video->setDescription($description);

                                //Récupération de l'objet url et status
                                $Obj_url= $urlRepository->findBy(['url' => $url ]);
                                $Obj_status= $videoStatusRepository->findBy(['status' => $status ]);
                                
                                foreach($Obj_url as $url){
                                    $id_url=$url->getId();
                                }
                                foreach($Obj_status as $status){
                                    $id_status=$status->getId();
                                }

                                 
                                $video->setIdUrl($id_url);
                                $video->setIdVideoStatus($id_status);
                                $video->setCreateAt (new \DateTime('now'));
                                $video->setUpdateAt (new \DateTime('now'));
                                //insertion d'un objet video
                                $em->persist($video);
                                $em->flush();
                            
                                //Récupération de l'objet video pour recupèré sont id et lui inseré dans la table user video 
                                $Obj_video= $videoRepository->findBy(['idUrl' => $id_url ]);
                                foreach($Obj_video as $video){
                                    $id_video=$video->getId();
                                }

                                $userVideo= new UserVideo();
                                $userVideo->setIdUser($identity->sub);
                                $userVideo->setidVideo($id_video);
                                $em->persist($userVideo);
                                $em->flush();
                                
                                $data =[
                                    'status'=>'success',
                                    'code'=> 200,
                                    'msg'=>"l'insertion a été faite correctement",
                                    ]; 
                                    
                            }else{
                                //recuperation de l'id de la url
                                $issetUrlUser=false;
                                foreach($isset_url as $url){
                                    $id_url=$url->getId();
                                }
                                
                                //recuperation de l'id des videos associée à la url
                                $Obj_video=$videoRepository->findBy(["idUrl"=>$id_url]);
                                
                                foreach($Obj_video as $video){
                                    $id_video=$video->getId();

                                    //recuperation de l'id  user pour verifie si c'est different a l'id login
                                    $Obj_userVideo=$userVideoRepository->findBy(["idVideo"=>$id_video]);
                                    
                                    foreach($Obj_userVideo as $uservideo){
                                        $id_user=$uservideo->getIdUser() ;
                                        if($id_user===$identity->sub){
                                            $issetUrlUser=true;
                                            
                                        }
                                    }
                                }
                                // la url pertenece a otro utilisador que el utilisador registrado
                                if(!$issetUrlUser){
                                    
    
                                    //Récupération de l'objet status
                                                                     
                                    $Obj_status= $videoStatusRepository->findBy(['status' => $status ]);
                                    
                                    foreach($Obj_status as $status){
                                        $id_status=$status->getId();
                                    }
                                    
                                    //creation de l'objet video 
                                    $video= new Video();
                                    $video->setTitle($title);
                                    $video->setDescription($description); 
                                    $video->setIdUrl($id_url);
                                    $video->setIdVideoStatus($id_status);
                                    $video->setCreateAt (new \DateTime('now'));
                                    $video->setUpdateAt (new \DateTime('now'));
                                    //insertion d'un objet video dans la DDBB
                                    
                                    $em->persist($video);
                                    $em->flush();
                                
                                    //Récupération de l'objet video  inséré pour recupèré sont id et lui inseré dans la table user video 
                                    $Obj_video= $videoRepository->findOneBy(['idUrl' => $id_url,
                                                                            'title' => $title,
                                                                            'description' => $description,
                                                                            'idVideoStatus' => $id_status
                                                                          ]);
                                 
                                    //creation de l'objet video 
                                    $userVideo= new UserVideo();
                                    $userVideo->setIdUser($identity->sub);
                                    $userVideo->setIdVideo($Obj_video->getId());
                                    $em->persist($userVideo);
                                    $em->flush();
                                    
                                    $data =[
                                        'status'=>'success',
                                        'code'=> 200,
                                        'msg'=>"l'insertion a été faite correctement",
                                        ]; 
                                }else{
                                    $data =[
                                        'status'=>'error',
                                        'code'=> 400,
                                        'msg'=>"cette url existe dans la base de données",
                                        ]; 
                                }
                               
                                
                            }
                            
        
                        }

                    }
                    return $this->json($data) ;
                }
            } catch (NotEncodableValueException $e) { // dans le cas ou le  json est mal formate
                return $this->json([
                   'status'=> 400,
                   'message'=> $e->getMessage()
               ], 400);
            }
        }
    }
    

    /**
     * Creation d'un video
     * 
     * @param Request $request
     * @param JwtAuth $jwtAuth
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     * @param VideoRepository $videoRepository
     * @param UrlRepository $urlRepository
     * @param UserVideoRepository $userVideoRepository
     * @param VideoStatusRepository $videoStatusRepository
     * @param [type] $id_video
     * @return void
     */
    public function updateVideo(
        Request $request, 
        JwtAuth $jwtAuth,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        VideoRepository $videoRepository,
        UrlRepository $urlRepository,
        UserVideoRepository $userVideoRepository,
        VideoStatusRepository $videoStatusRepository,
        $id_video
         ){
        
        
        $token=$request->headers->get('Authorization');
       
        $authtoken=$jwtAuth->checkToken($token);
            
        $data =[
            'status'=>'error',
            'code'=> 400,
            'msg'=>"impossible de modifier la vidéo",
            ];
         
           
           if ($authtoken) {

            $json=$request->get('json',null); 
            try{
                if ($json!=null) {  // $request->getContent()
                  $params= json_decode($json); // $params=json_decode($request->getContent());
                   
                    $identity=$jwtAuth->checkToken($token,true);

                    //recuperation id de l'utilisateur
                    $user_id=!empty($identity->sub) ? $identity->sub:null;
                   
                    //recuperacion des donnes envoie par l'interface
                    $title =(!empty($params->title)) ? $params->title:null;
                    $description =(!empty($params->description)) ? $params->description:null;
                    $url =(!empty($params->url)) ? $params->url:null;
                    $status =(!empty($params->statusVideo)) ? $params->statusVideo:null;
                    
                    if (!empty($user_id) && !empty($title) && !empty($description) &&  !empty($url) && !empty($status)) {

                        //creation d'un objet Url
                        $urlObj= new Url();
                        $urlObj->setUrl($url);
                        $errors=$validator->validate($urlObj);

                        if (count($errors)) { //verifie le type de champs envoie depuis l'interface
                            $errorsString = (string) $errors;
                            return new Response($errorsString);
                        }else{

                            // modification de la video   
                            $video_modif=$videoRepository->findOneBy(['id'=>$id_video]);
                            $video_modif->setTitle($title);
                            $video_modif->setDescription($description);
                            $video_modif->setUpdateAt (new \DateTime('now'));
                           
                            // modification de la url  
                            $url_modif= $urlRepository->findBy(['id' => $video_modif->getIdUrl()]);
                            foreach($url_modif as $url_video){
                                $url_video->setUrl($url);
                            }
                            // modification de l'status
                            $status_modif= $videoStatusRepository->findBy(['status' => $status]);
                            foreach($status_modif as $videostatus){
                                $idStatus=$videostatus->getId();
                            }
                            $video_modif->setIdVideoStatus($idStatus);
                            $em->persist($video_modif);
                            $em->persist($url_video);
                            $em->persist($videostatus);
                            $em->flush();
                            $data =[
                                'status'=>'success',
                                'code'=> 200,
                                'msg'=>"la modification a été faite correctement",
                                ];
                             }
                    }
                    return $this->json($data) ;
                }
            } catch (NotEncodableValueException $e) { // dans le cas ou le  json est mal formate
                return $this->json([
                   'status'=> 400,
                   'message'=> $e->getMessage()
               ], 400);
            }
        }
    }


    public function removeVideo(Request $request, 
        JwtAuth $jwtauth,
        VideoRepository $videoRepository,
        UrlRepository $urlRepository,
        UserVideoRepository $userVideoRepository,
        EntityManagerInterface $em,
        $id=null){
        $token=$request->headers->get("Authorization");
        
        $auth_token=$jwtauth->checkToken($token);
    
        $data=[
            'status'=>'error',
            'code'=>400,
            'msg'=>'impossible supprimer la vidéo', 
        ];
        if($auth_token){
           $identity=$jwtauth->checkToken($token, true);
           $videoSameUrl=false;  // variable qui permet de savoir s'il y a plus d'une vidéo avec la même url

           //récupération de l'objet vidéo sélectionné à supprimer dans les tables Video et table UserVideo
           $video=$videoRepository->findOneBy(['id'=>$id]);
           $userVideo=$userVideoRepository->findOneBy(['idVideo'=>$id]);

           //récupération de l'objet url sélectionné à supprimer dans la table Url
           $urlVideo=$urlRepository->findOneBy(['id'=>$video->getIdUrl()]);
           
           //savoir s'il existe d'autres vidéos avec la même url
           $video_url=$videoRepository->findBy(['idUrl'=>$video->getIdUrl()]);      
           foreach($video_url as $vid_url){
                if($vid_url->getId()!=$id){
                    $videoSameUrl=true;
                }
           }
           if($videoSameUrl){
            $em->remove($video);
            $em->remove($userVideo);
            $em->flush();
           
           }else{
            $em->remove($urlVideo);
            $em->remove($video);
            $em->remove($userVideo);
            $em->flush();
           }
           $data=[
            'status'=>'success',
            'code'=>200,
            'msg'=>' vidéo correctement supprimée', 
           ];
        }
       return $this->json($data);
    }
    
    public function detailVideo(
        Request $request, 
        JwtAuth $jwtauth,
        UrlRepository $urlRepository,
        VideoStatusRepository $videoStatusRepository,
        $id=null){
        // sacar el token y comprobar si es correcto
            $token= $request->headers->get('Authorization');
    
            $auth_token=$jwtauth->checkToken($token);
            $data=[
                   'status'=>'error',
                   'code'=>400,
                   'msg'=>"il n'y a aucun détail à montrer",    
            ];
            
        if($auth_token){
        // sacar la identidad del usuario
            $identity=$jwtauth->checkToken($token,true);
            
         //sacar el objeto del video en base a id
         $doctrine=$this->getDoctrine();
         $video_repo = $doctrine->getRepository(Video::class);
         $video=$video_repo->findBy(['id'=>$id]);
         
         //comprobar si el video existe  //comprobar si el video pertenece al usiario logueado
         if(!empty($video) /* && $identity->sub==$video->getUsers()->getId()*/){
                foreach($video as $vid){
                 $Obj_url=$urlRepository->findOneBy(['id'=>$vid->getidUrl()]);               
                 $url=$Obj_url->getUrl();
                 $Obj_status=$videoStatusRepository->findOneBy(['id'=>$vid->getIdVideoStatus()]);
                 $statusVideo=$Obj_status->getStatus();
                 $title=$vid->getTitle();
                 $description=$vid->getDescription();
                
                 
                }
                foreach($video as $vid){                    
                    
                   }
                
                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'video'=>$video, 
                    'title'=>$title,
                    'description'=>$description,
                    'url'=>$url,
                    'statusVideo' => $statusVideo,
                    


                ];    
                        
            }
        }
       return $this->json ($data);
    }

    public function listVideo(Request $request, 
    JwtAuth $jwtauth, 
    PaginatorInterface $paginator,
    EntityManagerInterface $em,
    UserVideoRepository $userVideoRepository,
    VideoRepository $videoRepository,
    UrlRepository $urlRepository,
    VideoStatusRepository $videoStatusRepository){ 
         
        //recoger datos de la cabecera

            $token=$request->headers->get('Authorization');
     
        //comprobar el Toke

            $authcheck=$jwtauth->checkToken($token);
              
        //Si es valido

            if($authcheck){
        //conseguir identidad del usuario
 
               $identity=$jwtauth->checkToken($token,true);


        // hacer una consulta para paginar
            $dql="SELECT v,u.url,vs.status
            FROM App\Entity\UserVideo uv
            INNER JOIN App\Entity\Video v
            WITH uv.idVideo =  v.id
            JOIN App\Entity\Url u
            WITH v.idUrl =  u.id
            JOIN App\Entity\VideoStatus vs
            WITH v.idVideoStatus =  vs.id
            WHERE uv.idUser =  $identity->sub
            ";
   

        // ejeccutar la consulta dql
               $query= $em->createQuery($dql);
              
        //recoger el parametro page de la url
               $page=$request->query->getInt('page',1); 
               
        //numer de video por pagina
               $items_per_page=5;
        //invocar paginacion
               $pagination=$paginator->paginate($query,$page,$items_per_page); 
               
        // numero total de items
              $totalItems=$pagination->getTotalItemCount(); 
             
        //preparar array de datos para devolver
               $data=[
                   'status'=>'success',
                   'code'=> 200,
                   '$items_per_page'=>$items_per_page,
                   '$page'=>$page,
                   '$totalItems'=>$totalItems,
                   'total_page'=>ceil($totalItems/$items_per_page),
                   'videos'=>$pagination,
                   'user_id'=>$identity->sub,
                   
                   
               ];
               
        //si falla devolver el array por defecto
              

        }else{
           $data=[
               'status'=>'error',
               'code'=> 400,
               'msg'=> 'there is not data in the DB',
               
            ];
        }

        return $this->json($data);
    }
}
