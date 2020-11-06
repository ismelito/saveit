<?php

namespace App\Services;

use Firebase\JWT\JWT;
use App\Entity\Login;
use App\Entity\Telephone;
use App\Entity\Sex;
use App\Entity\Nationality;
use App\Entity\MaritalStatus;
use App\Entity\TypeTelephone;
use App\Entity\Telefone;
use App\Entity\User;
use App\Repository\UserRepository;

class JwtAuth
{
    public $manager;
    public $key;

    public function __construct($manager)
    {
        $this->manager=$manager;
        $this->key='key01234';
    }

    /**
     * Return un objet si le login existe
     *
     * @param [type] $email
     * @param [type] $password
     * @param [type] $gettoken
     * @return $data
     */
    public function existsLogin($email, $password , $gettoken=null){
        
         // default answer

         $data=[
          'status'=>'error',
          'code'=>'400',
          'msg'=>'user not found',
        ];

        
      // default answer
          $login_repo=$this->manager->getRepository(Login::class);
         
          $login=$login_repo->findOneBy([
              'email'=>$email,
              'password'=>$password
          ]);
         
         
      //  if the user exists generate the token

          $signup=false;
          if(is_object($login)){
              $signup=true;
              
          }

          if($signup){
            
              $user_repo=$this->manager->GetRepository(User::class);
              $user=$user_repo->findOneBy(['idLogin' =>$login->getId()

              ]);
              
              $sex_repo=$this->manager->GetRepository(Sex::class);
              $sex=$sex_repo->findOneBy(['id' =>$user->getIdSex()

              ]);

              $nationality_repo=$this->manager->GetRepository(Nationality::class);
              $nationality=$nationality_repo->findOneBy(['id' =>$user->getIdNationality()

              ]);

              $marital_status_repo=$this->manager->GetRepository(MaritalStatus::class);
              $marital_status=$marital_status_repo->findOneBy(['id' =>$user->getIdMaritalStatus()

              ]);

              $telephone_repo=$this->manager->GetRepository(Telephone::class);
              $telephone=$telephone_repo->findOneBy(['idUser' => $user->getId()

              ]);
              
              if($telephone){
                    
                    $type_telephone_repo=$this->manager->GetRepository(TypeTelephone::class);
                    $type_telephone=$type_telephone_repo->findOneBy(['id' =>$telephone->getIdTypeTelephone()
                    ]);
                    $telep=$telephone->getTelephone();
                    $type_telep=$type_telephone->getTypetelephone();
              }
              else{
                    $telep=" ";
                    $type_telep=" ";
              }
              
              
           $token=[
                      'sub'=>$user->getId(),
                      'name'=>$user->getName(),
                      'lastname'=>$user->getLastName(),
                      'birthday'=>$user->getBirthday(),
                      'login'=>$login->getId(),
                      'email'=>$login->getEmail(),
                      'password'=>$login->getPassword(),
                      'role'=>$user->getIdRole(),
                    /*'nationality'=>$user->getIdNationality(),
                      'maritalstatus'=>$user->getIdMaritalStatus(),
                      'sex'=>$user->getIdSex(),*/
                      'nationality'=>$nationality->getNationality(),
                      'maritalstatus'=>$marital_status->getMaritalStatus(),
                      'sex'=>$sex->getSex(),
                      'telephone'=> $telep,
                      'type_telephone'=> $type_telep,
                      'createAt'=>$user->getCreateAt(),
                      'updateAt'=>$user->getUpdateAt(),
                      'iat'=>time(),
                      'exp'=>time() + (7 * 24 *60 *60),

               ];
              
              
      //code le token

          $jwt=JWT::encode($token,$this->key,'HS256');

      //  check the flag gettoken with a condition
         
          if(!empty($gettoken)){
            
              $data=$jwt;
              
          }else{
              $decode=JWT::decode($jwt,$this->key,['HS256']);
              $data=$decode; 
          }
      }

      //  return the data  
      
        return $data;
  }


  /**
   * Checking token login   
   * @param [type] $jwt
   * @param boolean $auth_identity
   * @return $auth | $decoded
   */
  public function checkToken($jwt, $auth_identity=false){
        
       
    (boolean) $auth=false;
    try{
        $decoded=JWT::decode($jwt,$this->key,['HS256']);
        if(isset($decoded) && !empty($decoded) && is_object($decoded) && isset($decoded->sub) )
            $auth=true;           
     
        if($auth_identity)
            return $decoded;
        else
            return $auth;
        
    }
    
    catch(\Exception $e){
      
        return false;
    }     

    
  

}

/**
 * Verifie avant faire la creation d'un utilisateur si le email existe
 *
 * @param [type] $email
 * @return $data
 */
public function verificacionLogin($email=null,$idLogin=null){
    
    // default answer
    $data=[
        'status'=>'error',
        'code'=>'400',
        'msg'=>'utilisateur non trouvé',
      ];

      $login_repo=$this->manager->getRepository(Login::class);
      
      $login=$login_repo->findOneBy([
        'email'=>$email,
      ]);
      
    if($idLogin){
        
        if ($email) {// modification d'un login
             
            if (is_object($login)) { //si no existe
                
                if ($login->getId()!=$idLogin) { // si existe mais appartient à un autre utilisateur
                    
                    $data=$login;
                }else{//si existe et appartient à un l'utilisateur en question
                    return $data;
                }
              
            }
         }else{// delete d'un login
            $log=$login_repo->findOneBy([
                'id'=>$idLogin,
            ]);
            if (is_object($log)) {
         
                $data=$log->getId();
            }
        }

    }else{//creation d'un login

        if(is_object($login)){
            $data=$login;
        } 
            
    }
    
        return $data;
  }

/**
 * Verifie si le telephone existe avant de faire la creation d'un utilisateur
 *
 * @param [type] $telephone
 * @param [type] $id_user
 * @return $data;
 */

public function verificacionTelephone($teleph=null,$id_user=null){
   
   
   // default answer
    $data=[
        'status'=>'error',
        'code'=>'400',
        'msg'=>'utilisateur non trouvé',
      ];
 
    
        $telephone_repo=$this->manager->getRepository(Telephone::class);
        $telephone=$telephone_repo->findOneBy([
            'telephone'=>$teleph,
        ]);
       
        if($id_user){
            $userTelephone=$telephone_repo->findOneBy([
                'idUser'=>$id_user,
            ]);
            if($teleph ){
            
                

                if (is_object($telephone)) { //si existe
                
                    if ($telephone->getIdUser()!=$id_user) { // si existe mais appartient à un autre utilisateur
                        
                        $data=$telephone;
                        return $data;
                    }else{//si existe et appartient à l'utilisateur en question
                        $data="modification";
                        return $data;
                    } 
                  
                }else if( is_object($userTelephone) ){
                    $data="modification";
                    return $data;
                }else{
                    //si l'utilisateur exite mais il pas de
                    $data="new";
                }
                
            }else{// delete d'un utilisateur
                
                $telephone=$telephone_repo->findBy([
                    'idUser'=>$id_user,
                ]);
                
                if (is_object($telephone)) {
                    $data=$telephone->getId();
                }
            }
            
        }else{ //creation d'un utilisateur

            if(is_object($telephone)){
                $data=$telephone;
            }
              
        }
        return $data;
  }

}
