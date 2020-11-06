<?php

namespace App\Controller;

use App\Entity\DateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validation;



use App\Repository\UserRepository;
use App\Repository\LoginRepository;
use App\Repository\TelephoneRepository;
use App\Repository\MaritalStatusRepository;
use App\Repository\TypeTelephoneRepository;
use App\Repository\SexRepository;
use App\Repository\NationalityRepository;
use App\Repository\RoleRepository;
use App\Repository\UserVideoRepository;
use App\Repository\VideoRepository;
use App\Repository\UrlRepository;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\Url;
use App\Entity\Login;
use App\Entity\Telephone;
use App\Entity\MaritalStatus;
use App\Entity\Role;
use App\Entity\Nationality;
use App\Entity\Sex;
use App\Entity\TypeTelephone;



use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Services\JwtAuth ;


class UserController extends AbstractController
{
    public function index(UserRepository  $userrepository, SerializerInterface $serializer)
    {
       /* return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);*/
        return  $this->json($userrepository->findAll(), 200, [], ['groups' =>'role:read']);
    }

    /**
     *  Creation d'utilisateur
     *
     * @param UserRepository $userRepository
     * @param LoginRepository $loginrepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param MaritalStatusRepository $maritalStatusRepository
     * @param RoleRepository $roleRepository
     * @param NationalityRepository $nationalityRepository
     * @param SexRepository $sexRepository
     * @param TypeTelephoneRepository $typeTelephoneRepository
     * @param LoginController $loginController
     * @param JwtAuth $jwtAuth
     * @return $data
     */
    public function createUser(
        UserRepository $userRepository,
        LoginRepository $loginrepository,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        MaritalStatusRepository $maritalStatusRepository,
        RoleRepository $roleRepository,
        NationalityRepository $nationalityRepository,
        SexRepository $sexRepository,
        TypeTelephoneRepository $typeTelephoneRepository,
        
        JwtAuth $jwtAuth
    ) {

        // take the data by post (recoger) in case it doesn't arrive it will be null
         $json=$request->get('json',null); 
         
  
        $data=[
            'status'=>'error',
            'code'=>'400',
            'msg'=>'utilisateur non enregistré',
            
          ];
          
        try {
            if ($json!=null) {
                //$params=json_decode($request->getContent());
                //decode the json
                // $param= json_decode($json,true); dos formas de hacerlo para descodificar un objeto 
                $params= json_decode($json);// utilizando JsonResponse
                
                $name=(!empty($params->name)) ? $params->name:null;
                $lastname=(!empty($params->lastname)) ? $params->lastname:null;
                $birthday=(!empty($params->birthday)) ? $params->birthday:null;
                $marital_Status=(!empty($params->marital_Status)) ? $params->marital_Status:null;
                $nationality=(!empty($params->nationality)) ? $params->nationality:null;
                $sex=(!empty($params->sex)) ? $params->sex:null;
                $type_telephone=(!empty($params->type_telephone)) ? $params->type_telephone:null;
                $telephone=(!empty($params->telephone)) ? $params->telephone:null;
                $email=(!empty($params->email)) ? $params->email:null;
                $password=(!empty($params->password)) ? $params->password:null;
                
                if(!empty($name) && !empty($lastname) && !empty($birthday) && !empty($marital_Status) 
                   && !empty($nationality) && !empty($sex) && !empty($email) && !empty($password)){
                    //creation d'un object login pour faire la validation de champs et plus tard lui insere en BBDD
                    $loginnew= new Login();
                    $loginnew->setEmail($email);
                    $pwd=Hash('sha256', $password); //codification  mot passe
                    $loginnew->setPassword($pwd);
                    //creationd'un objet user
                    
                    $errors=$validator->validate($loginnew);

                    if (count($errors)) { //verifie le type de champs envoie depuis l'interface
                        $errorsString = (string) $errors;
                        return new Response($errorsString);
                    }else{

                        $isset_email=$jwtAuth->verificacionLogin($email);   // verification si le mail il est deja existant
                        
                        if (!is_object($isset_email)) {

                            //Récupération de l'objet d'autres champs
                            $Obj_maritalStatus= $maritalStatusRepository->findBy(['maritalStatus' => $marital_Status ]);
                            $Obj_role= $roleRepository->findBy(['role' => 'Utilisateur' ]);
                            $Obj_nationality= $nationalityRepository->findBy(['nationality' => $nationality ]);
                            $Obj_sex= $sexRepository->findBy(['sex' => $sex ]);
                            
                            //verificacion si el object exit
                            if ($Obj_maritalStatus && $Obj_role && $Obj_nationality && $Obj_sex) {
                                
                                //Récupération de l'identifiant de nationality pour l'insérer dans la table user
                                foreach ($Obj_maritalStatus as $obj_maritalStatus) {
                                    $id_maritalStatus=$obj_maritalStatus->getId();
                                }
                            
                                foreach ($Obj_role as $obj_role) {
                                    $id_role=$obj_role->getId();
                                }
                                
                                foreach ($Obj_nationality as $obj_nationality) {
                                    $id_nationality=$obj_nationality->getId();
                                }
                                
                                foreach ($Obj_sex as $obj_sex) {
                                    $id_sex=$obj_sex->getId();
                                }

                            }
                            if (!empty($telephone) && !empty($type_telephone)) {
                                $isset_telephone=$jwtAuth->verificacionTelephone($telephone);  
                                if (!is_object($isset_telephone)) {
                                   //insersion BBDD
                                    $em->persist($loginnew);
                                    $em->flush();
                                    
                                    //Récupération de l'identifiant de Login pour l'insérer dans la table user
                                    $Obj_login= $loginrepository->findBy(['email' => $email ]);
                                    foreach ($Obj_login as $obj_login) {
                                        $id_login=$obj_login->getId();
                                    }

                                    //Creation d'un user
                                    $user=new User();
                                    $user->setName($name);
                                    $user->setLastName($lastname);
                                    $user->setBirthday($birthday);
                                    $user->setIdLogin($id_login);
                                    $user->setIsActive(1);
                                    $user->setIdRole($id_role);
                                    $user->setIdNationality($id_nationality);
                                    $user->setIdMaritalStatus($id_maritalStatus);
                                    $user->setIdSex($id_sex);
                                    $user->setCreateAt(new \DateTime('now'));
                                    $user->setUpdateAt(new \DateTime('now'));
                                    $em->persist($user);
                                    $em->flush();

                                    //Récupération de l'identifiant de User pour l'insérer dans la table telephone
                                    $Obj_user= $userRepository->findBy(['idLogin' => $id_login ]);
                                    foreach ($Obj_user as $obj_user) {
                                        $id_user=$obj_user->getId();
                                    }
                                    //Récupération de l'identifiant de User pour l'insérer dans la table telephone
                                    $Obj_typeTelephone= $typeTelephoneRepository->findBy(['typetelephone' => $type_telephone ]);
                                    foreach ($Obj_typeTelephone as $obj_typeTelephone) {
                                        $id_typeTelephone=$obj_typeTelephone->getId();
                                    }

                                    ////Creation d'un telephone
                                    $teleph=new Telephone();
                                    $teleph->setIdUser($id_user);
                                    $teleph->setTelephone($telephone);
                                    $teleph->setIDTypeTelephone($id_typeTelephone);

                                    //insertion dans BBDD
                                    $em->persist($teleph);
                                    $em->flush();

                                    $data=[
                                        'status'=>'success',
                                        'code'=>'200',
                                        'msg'=>'utilisateur enregistré',
                                        'user'=> $user,
                                        'telephone'=> $teleph
                                      ];
                                }else{
                                        
                                    $data=[
                                        'status'=>'error',
                                        'code'=>'400',
                                        'msg'=>'le téléphone sélectionné existe déjà ',
                                        
                                      ];
                                }
                               
                            }else{

                                 //insertion dans BBDD
                                 $em->persist($loginnew);
                                 $em->flush();
                                 
                                 //Récupération de l'identifiant de Login pour l'insérer dans la table user
                                 $Obj_login= $loginrepository->findBy(['email' => $email ]);
                                 foreach ($Obj_login as $obj_login) {
                                     $id_login=$obj_login->getId();
                                 }

                                 //Creation d'un user
                                 $user=new User();
                                 $user->setName($name);
                                 $user->setLastName($lastname);
                                 $user->setBirthday($birthday);
                                 $user->setIdLogin($id_login);
                                 $user->setIsActive(1);
                                 $user->setIdRole($id_role);
                                 $user->setIdNationality($id_nationality);
                                 $user->setIdMaritalStatus($id_maritalStatus);
                                 $user->setIdSex($id_sex);
                                 $user->setCreateAt(new \DateTime('now'));
                                 $user->setUpdateAt(new \DateTime('now'));
                                 
                                 //insertion dans BBDD
                                 $em->persist($user);
                                 $em->flush();

                                 $data=[
                                    'status'=>'success',
                                    'code'=>'200',
                                    'msg'=>'utilisateur  enregistré',
                                    'user'=> $user
                                  ];

                           }
                            
                        } 
                    }

                }
               return $this->json($data);
            }
        } catch (NotEncodableValueException $e) { // dans le cas ou le  json est mal formate
            return $this->json([
               'status'=> 400,
               'message'=> $e->getMessage()
           ], 400);
        }
    }

    /**
     * 
     * Login utilisateur     
     *
     * @param JwtAuth $jwtAuth
     * @param UserRepository $userRepository
     * @param LoginRepository $loginrepository
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return $data
     */
    public function loginUser(JwtAuth $jwtAuth,
     UserRepository $userRepository,
     LoginRepository $loginrepository, 
     Request $request, 
     ValidatorInterface $validator)
    {
        
      // take the data by post (recoger) in case it doesn't arrive it will be null
       $json=$request->get('json',null); 
       //$params=json_decode($request->getContent());
         
  
      $data=[
          'status'=>'error',
          'code'=>'400',
          'msg'=>'utilisateur non-identifié',
          
        ];
        
      try {
          if ($json!=null ) {//$params=json_decode($request->getContent());
              
              //decode the json
              // $param= json_decode($json,true); dos formas de hacerlo para descodificar un objeto 
              $params= json_decode($json);// utilizando JsonResponse
                $email=(!empty($params->email)) ? $params->email : null ;
                $password=(!empty($params->password)) ? $params->password :null;
                $gettoken=(!empty($params->gettoken)) ? $params->gettoken :null;
                if (!empty($email) && !empty($password)) {
                    $loginnew= new Login();
                    $loginnew->setEmail($params->email);
                    $password=$params->password ;
                    $pwd=Hash('sha256', $password);
                    $loginnew->setPassword($pwd);
                    $errors=$validator->validate($loginnew);
                    
                    if (count($errors)) { //verifie le type de champs envoie depuis l'interface
                        $errorsString = (string) $errors;
                        return new Response($errorsString);
                    } else {
                       
                        
                        $issetlogin=$jwtAuth->verificacionLogin($email);
                        
                        $idLogin=$issetlogin->getId();
                        
                        $user_repo=$userRepository->findOneBy(['idLogin'=> $idLogin]);
                                       
                        if($user_repo->getIsActive()){
                            
                            if ($gettoken) {
                                $signup=$jwtAuth->existsLogin($params->email, $pwd, $params->gettoken);
                               
                            } else {
                                $signup=$jwtAuth->existsLogin($params->email, $pwd);
                            }
                            return new JsonResponse($signup);
                        }else{
                            $data=[
                                'status'=>'error',
                                'code'=>'400',
                                'msg'=>'utilisateur supprimé',
                                ];
                        }
                        
                    }
                   
                   
                }
                return $this->json([
                'data'=> $data,
            ]);
            }
        } catch (NotEncodableValueException $e) { // dans le cas ou le  json est mal formate
            return $this->json([
           'status'=> 400,
           'message'=> $e->getMessage()
       ], 400);
        }
       
    }

    /**
     * Modification d'un utilisateur
     *
     * @param JwtAuth $jwtAuth
     * @param UserRepository $userRepository
     * @param LoginRepository $loginrepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param MaritalStatusRepository $maritalStatusRepository
     * @param RoleRepository $roleRepository
     * @param NationalityRepository $nationalityRepository
     * @param SexRepository $sexRepository
     * @param TypeTelephoneRepository $typeTelephoneRepository
     * @return $data
     */

    public function updateUser(
        JwtAuth $jwtAuth,
        TelephoneRepository $telephoneRepository,
        UserRepository $userRepository,
        LoginRepository $loginrepository,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        MaritalStatusRepository $maritalStatusRepository,
        RoleRepository $roleRepository,
        NationalityRepository $nationalityRepository,
        SexRepository $sexRepository,
        TypeTelephoneRepository $typeTelephoneRepository
        )
    {
        try {
            $token=$request->headers->get('Authorization');

            $authtoken=$jwtAuth->checkToken($token);
            
         
            $data =[
                'status'=>'error',
                'code'=> 400,
                'msg'=>"modification incorrecte de l'utilisateur",
                
                ];
             
    
            if ($authtoken) {                  
                       
                //  get the data of the identified user
                $identity=$jwtAuth->checkToken($token, true);
                     
                     
                //  get the user data to be fully updated
                $user=$userRepository->findOneBy([
                    'id'=> $identity->sub,
                    ]);
                    
                    $idLogin=$user->getIdLogin();
                    $idUser=$user->getId();
   

                    $json=$request->get('json',null);
                    $params=json_decode($json);

               //  collect and validate data
                if ($json!=null) {
                    
                    //  check and validate
                   
                    $name=(!empty($params->name)) ? $params->name:null;
                    $lastname=(!empty($params->lastname)) ? $params->lastname:null;
                    $birthday=(!empty($params->birthday)) ? $params->birthday:null;
                    $marital_Status=(!empty($params->marital_Status)) ? $params->marital_Status:null;
                    $nationality=(!empty($params->nationality)) ? $params->nationality:null;
                    $sex=(!empty($params->sex)) ? $params->sex:null;
                    $type_telephone=(!empty($params->type_telephone)) ? $params->type_telephone:null;
                    $telephone=(!empty($params->telephone)) ? $params->telephone:null;
                    $email=(!empty($params->email)) ? $params->email:null;
                    $password=(!empty($params->password)) ? $params->password:null;
                            
                    if ( !empty($name) && !empty($lastname) && !empty($birthday) && !empty($marital_Status) && !empty($nationality)
                    && !empty($sex) && !empty($email) && !empty($password) ) {
                        
                        // $validate_email (login)
                        $login= new Login();
                        $login->setEmail($email);
                        $pwd=Hash('sha256', $password); //codification  mot passe
                        $login->setPassword($pwd);

                        //dd("fff",$login);
                        
                        $errors=$validator->validate($login);
                        
                        if (count($errors)) { //verifie le type de champs envoie depuis l'interface
                            $errorsString = (string) $errors;
                            return new Response($errorsString);
                        } else {

                            $isset_email=$jwtAuth->verificacionLogin($email,$idLogin);   // verification si le mail il est deja existant
                          
                            if (!is_object($isset_email)) {
    
                                //Récupération de l'objet d'autres champs
                                $Obj_maritalStatus= $maritalStatusRepository->findBy(['maritalStatus' => $marital_Status ]);
                                $Obj_role= $roleRepository->findBy(['role' => 'Utilisateur' ]);
                                $Obj_nationality= $nationalityRepository->findBy(['nationality' => $nationality ]);
                                $Obj_sex= $sexRepository->findBy(['sex' => $sex ]);

    
                                //verificacion si el object exit
                                if ($Obj_maritalStatus && $Obj_role && $Obj_nationality && $Obj_sex) {
                                    
                                    //Récupération de l'identifiant de nationality pour l'insérer dans la table user
                                    foreach ($Obj_maritalStatus as $obj_maritalStatus) {
                                        $id_maritalStatus=$obj_maritalStatus->getId();
                                    }
                                
                                    foreach ($Obj_role as $obj_role) {
                                        $id_role=$obj_role->getId();
                                    }
                                    
                                    foreach ($Obj_nationality as $obj_nationality) {
                                        $id_nationality=$obj_nationality->getId();
                                    }
                                    
                                    foreach ($Obj_sex as $obj_sex) {
                                        $id_sex=$obj_sex->getId();
                                    }
    
                                }
                               
                                if (!empty($telephone) && !empty($type_telephone)) {
                                   
                                    
                                    $isset_telephone=$jwtAuth->verificacionTelephone($telephone,$idUser);  
                                    
                                    if (!is_object($isset_telephone)) {
                                       
                                       //insersion login BBDD
                                       $Obj_login=$loginrepository->findBy(['id' => $idLogin]);
                                       foreach ($Obj_login as $obj_login) {
                                           $obj_login->setEmail($email);
                                           $obj_login->setPassword($pwd);
                                           $em->persist($obj_login);
                                           $em->flush();
                                       }                                        
                                    
                                        //Modification d'un user
                                       
                                        $user->setName($name);
                                        $user->setLastName($lastname);
                                        $user->setBirthday($birthday);
                                       // $user->setLogin($id_login);
                                       // $user->setRole($id_role);
                                        $user->setIdNationality($id_nationality);
                                        $user->setIdMaritalStatus($id_maritalStatus);
                                        $user->setIdSex($id_sex);
                                       // $user->setCreateAt(new \DateTime('now'));
                                        $user->setUpdateAt(new \DateTime('now'));
                                        $em->persist($user);
                                        $em->flush();
    
                                      
                                        //Récupération de l'identifiant de User pour l'insérer dans la table telephone
                                        $Obj_typeTelephone= $typeTelephoneRepository->findBy(['typetelephone' => $type_telephone ]);
                                        foreach ($Obj_typeTelephone as $obj_typeTelephone) {
                                            $id_typeTelephone=$obj_typeTelephone->getId();
                                        }
    
                                        if($isset_telephone==="new"){
                                            
                                            //Creation d'un telephone
                                            $teleph=new Telephone();
                                            $teleph->setIDUser($idUser);
                                            $teleph->setTelephone($telephone);
                                            $teleph->setIdTypeTelephone($id_typeTelephone);

                                            //insertion dans BBDD
                                            $em->persist($teleph);
                                            $em->flush();
                                        }else{
                                            
                                            $Obj_tel=$telephoneRepository->findBy(['idUser' => $idUser]);
                                            foreach ($Obj_tel as $obj_tel) {
                                                $teleph=$obj_tel->setTelephone($telephone);
                                            }
                                            $em->persist($teleph);
                                            $em->flush();
                                        }
                                        
    
                                        $data=[
                                            'status'=>'success',
                                            'code'=>'200',
                                            'msg'=>'utilisateur enregistré',
                                            'user'=> $user,
                                            'telephone'=> $teleph
                                          ];
                                    } 
                                   
                                }else{
    
                                    $telephoneDelete=$jwtAuth->verificacionTelephone(null,$idUser); 
                                    
                                    if($telephoneDelete) {
                                       
                                       
                                        $Obj_telephone=$telephoneRepository->find($telephoneDelete);
                                        $em->remove($Obj_telephone);
                                        $em->flush();
                                    }
                                    
                                    //insersion login BBDD
                                    $Obj_login=$loginrepository->findBy(['id' => $idLogin]);
                                    foreach ($Obj_login as $obj_login) {
                                        $obj_login->setEmail($email);
                                        $obj_login->setPassword($pwd);
                                        $em->persist($obj_login);
                                        $em->flush();
                                    }                                        
                                 
                                     //Modification d'un user
                                    
                                     $user->setName($name);
                                     $user->setLastName($lastname);
                                     $user->setBirthday($birthday);
                                    // $user->setLogin($id_login);
                                    // $user->setRole($id_role);
                                     $user->setIdNationality($id_nationality);
                                     $user->setIdMaritalStatus($id_maritalStatus);
                                     $user->setIdSex($id_sex);
                                    // $user->setCreateAt(new \DateTime('now'));
                                     $user->setUpdateAt(new \DateTime('now'));
                                     $em->persist($user);
                                     $em->flush();
    
                                     $data=[
                                        'status'=>'success',
                                        'code'=>'200',
                                        'msg'=>'utilisateur  enregistré',
                                        'user'=> $user
                                      ];
    
                               }
                                
                            } 
                        }
                    }
               
                     
                }
            }
            return $this->json($data);
        
        } catch (NotEncodableValueException $e) { // dans le cas ou le  json est mal formate
            return $this->json([
       'status'=> 400,
       'message'=> $e->getMessage()
   ], 400);
        }
    }
    
    /**
     * Delete user
     *
     * @param JwtAuth $jwtauth
     * @param UserRepository $userRepository
     * @param LoginRepository $loginrepository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param MaritalStatusRepository $maritalStatusRepository
     * @param RoleRepository $roleRepository
     * @param NationalityRepository $nationalityRepository
     * @param SexRepository $sexRepository
     * @param TypeTelephoneRepository $typeTelephoneRepository
     * @return $data
     */
    public function deleteUser(JwtAuth $jwtauth, Request $request,
    SerializerInterface $serializer,
    EntityManagerInterface $em,
    ValidatorInterface $validator,
    UserRepository $userRepository,
    LoginRepository $loginrepository,
    MaritalStatusRepository $maritalStatusRepository,
    RoleRepository $roleRepository,
    NationalityRepository $nationalityRepository,
    SexRepository $sexRepository,
    TypeTelephoneRepository $typeTelephoneRepository
    
    ){
        
        
        //capture le token du registrement
        $token=$request->headers->get("Authorization");
        //verification du token
        $auth_token=$jwtauth->checkToken($token);

        $data=[
            'status'=>'error',
            'code'=>400,
            'msg'=>"impossible la suppression de l'utilisateur",
        ];
      
        if ($auth_token) {
            $identity=$jwtauth->checkToken($token, true);// obtention des donnes d'authentication
            if($identity){
                $user_repo=$userRepository->findOneBy(['id'=>$identity->sub]);
                $user_repo->setIsActive(0);
                $em->persist($user_repo);
                $em->flush();
                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'msg'=>"l'utilisateur a été supprimé",
                ];
            }
            
         
        }
        return $this->json($data);
    }

    /**
     * Delete user admin
     *
     * @param JwtAuth $jwtauth
     * @param UserRepository $userRepository
     * @param LoginRepository $loginrepository
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TelephoneRepository $telephoneRepository
     * @param TelephoneRepository $telephoneRepository
     * @param VideoRepository $videoRepository,
     * @param UrlRepository $urlRepository,
     * @param [type] $id
     * @return $data
     */
    public function deleteUserAdmin(JwtAuth $jwtauth, Request $request,
    EntityManagerInterface $em,
    UserRepository $userRepository,
    LoginRepository $loginrepository,
    TelephoneRepository $telephoneRepository,
    UserVideoRepository $userVideoRepository,
    VideoRepository $videoRepository,
    UrlRepository $urlRepository,
    $id
    ){
        
        
        //capture le token du registrement
        $token=$request->headers->get("Authorization");
        //verification du token
        $auth_token=$jwtauth->checkToken($token);

        $data=[
            'status'=>'error',
            'code'=>400,
            'msg'=>"impossible de supprimer l'utilisateur",
        ];
      
        if ($auth_token) {
            $identity=$jwtauth->checkToken($token, true);// obtention des donnes d'authentication
            // récupération des objets à supprimer selon l'identifiant
            $user_repo=$userRepository->findOneBy(['id'=>$id]);
            $user_login=$loginrepository->findOneBy(['id'=>$user_repo->getIdLogin()]);
            $user_telephone=$telephoneRepository->findOneBy(['idUser'=>$id]);
            $user_video=$userVideoRepository->findOneBy(['idUser'=>$id]);
           

            if(is_object($user_video)){
                // récupération de  l'objet video à supprimer selon l'identifiant
                $video_repo=$videoRepository->findOneBy(['id'=>$user_video->getIdVideo()]);
                // récupération de tous  l'objets video avec cette url
                $many_video_url=0;
                $video_url=$videoRepository->findAll(['idUrl'=>$video_repo->getIdUrl()]);
                foreach($video_url as $url){
                    $many_video_url++;
                }
                // s'il existe une seule url associée à une vidéo appartenant à un utilisateur
                if($many_video_url==1){
                    $url_repo=$urlRepository->findOneBy(['id'=>$video_repo->getIdUrl()]);
                    $em->remove($url_repo);
                    $em->remove($video_repo);
                    $em->remove($user_video);
                    $em->remove($user_telephone);
                    $em->remove($user_login);
                    $em->remove($user_repo);
                    $em->flush();
                }else{ // si la même url est associée à différentes vidéos appartenant à différents utilisateurs
                    $em->remove($video_repo);
                    $em->remove($user_video);
                    $em->remove($user_telephone);
                    $em->remove($user_login);
                    $em->remove($user_repo);
                    $em->flush();
                }
                
            }else{
                    
                    $em->remove($user_telephone);
                    $em->remove($user_login);
                    $em->remove($user_repo);
                    $em->flush();
                }
            $data=[
                'status'=>'success',
                'code'=>200,
                'msg'=>'utilisateur supprimé correctement',
            ];
        }
        return $this->json($data);
    }
 

}