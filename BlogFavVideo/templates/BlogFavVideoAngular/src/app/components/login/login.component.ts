import { Component, OnInit } from '@angular/core';
//redirigir el usuario a la home de la app
import{Router,ActivatedRoute,Params} from '@angular/router'
import{User} from '../../models/user';
import{UserService} from '../../services/user.services';
import { from } from 'rxjs';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers:[UserService]
})
export class LoginComponent implements OnInit{

  public page_title:string;
  public status:string;
  public token:string;
  public identity:string;
  public user:User;
  
  public showPassword = false; // variable de control d'état de mot de passe
  
constructor(
    private _userservice:UserService,
    //para hacer la redireccion a una pagina una vez logueado
    private _router:Router,
    private _route:ActivatedRoute,
) {
    this.page_title="Identifiez-vous";
    this.user= new User('','','','','','','','','','');
    
  }

  ngOnInit(): void {
    this.logout();
  }  
  
  onSubmit(form){
    
    this._userservice.signup(this.user).subscribe(
      response=>{
        
          if(!response.status || response.status!="error"){
               this.status="success";
               this.identity=response;
               this._userservice.signup(this.user,true).subscribe(
                response=>{
                  
                    if(!response.status || response.status!="error"){
                         
                         this.token=response;
                         console.log('t',this.token);
                         console.log('I',this.identity);
                         //guardar l'informacion en localstorege dentro de la seccion
                         localStorage.setItem('token',this.token);
                         //dentro del localStorage no podemos guardar un objeto, solo se puede guardar texto o numeros
                         //se debe convertir ese objeto a un json string
                         localStorage.setItem('identity',JSON.stringify(this.identity));
                         //redireccion a una pagina 
                         this._router.navigate(['/home']);
                        
                    }else{
                     this.status="error";
                    }
                },
                error=>{
                  this.status='error';
                }
               )
          }else{
           this.status="error";
          }
      },
      error=>{
        this.status='error';
      }
 
    )
   }
   /**
    * Function qui fait passer l'état du mot de passe de l'invisible au visible
    * @type {toggleShowPassword}
    */
   toggleShowPassword () {
     this.showPassword = !this.showPassword;
     console.log(this.showPassword);
   }

    /**
    * Function qui qui ferme la seccion
    * @type {logout}
    */
   logout () {
      this._route.params.subscribe( params => {
        let sure= +params['sure'];  //convertir a un entero el parametro que llega por la url

        if(sure ==1){
          
          localStorage.removeItem('identity');
          localStorage.removeItem('token');
          this.identity=null;
          this.token=null;
          this._router.navigate(['/login']);
        }
    });
    
      
    }
 

}
