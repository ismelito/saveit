import { Component, OnInit } from '@angular/core';
import{Router,ActivatedRoute,Params} from '@angular/router';// import para la navegation
import{User} from '../../models/user';

import{UserService} from '../../services/user.services';
import{SatelitetableService} from '../../services/satelitetable.services';
import { from } from 'rxjs';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers:[UserService,SatelitetableService]
})
export class RegisterComponent implements OnInit {
    public page_title:string;
    public status:string;
    public user:User;
    public typeTelephone;
    public Sex;
    public Nationality;
    public MaritalStatus;
    
    public showPassword = false; // variable de control d'état de mot de passe
    
  constructor(
      private _router:Router,
      private _route:ActivatedRoute,
      private _userservice:UserService,
      private _satelitetableService:SatelitetableService
  ) {
    this.page_title="Enregistrez-vous";
    this.user= new User('','','','','','','','','','');
    
    
   }

  ngOnInit(): void {
    console.log("user",this.user);
    console.log("typeTelephone",this.typeTelephone);
    this.sateliteTable();
  }
  onSubmit(form){
    
      this._userservice.register(this.user).subscribe(
        response=>{
            if(response.status=="success"){
                  this.status="success";
                 // form.reset();
                  this._router.navigate(['/login']);
            }else{
              this.status="error";
            }
        },
        error=>{
          this.status='error';
        }

      );
  }

  sateliteTable(){
      this._satelitetableService.getTypesTelephones().subscribe(
        response=>{
            
            if(response.status=="success"){
                this.status="success";
                this.typeTelephone=response.typetelephone;
                
                
            }else{
            this.status="error";
            }
        },
        error=>{
          this.status='error';
        }
  
      );
      this._satelitetableService.getSex().subscribe(
        response=>{
          
            if(response.status=="success"){
                this.status="success";
                this.Sex=response.sex;
                
                
            }else{
            this.status="error";
            }
        },
        error=>{
          this.status='error';
        }
  
      );
      this._satelitetableService.getNationality().subscribe(
        response=>{
          
          
            if(response.status=="success"){
                this.status="success";
                this.Nationality=response.nationality;
                
                
            }else{
            this.status="error";
            }
        },
        error=>{
          this.status='error';
        }
  
      ); 
      this._satelitetableService.getMaritalStatus().subscribe(
        response=>{
          
            if(response.status=="success"){
                this.status="success";
                this.MaritalStatus=response.maritalStatus;                
                
            }else{
            this.status="error";
            }
        },
        error=>{
          this.status='error';
        }
  
      );
   }

  /**
   * Function qui fait passer l'état du mot de passe de l'invisible au visible
   * @type {toggleShowPassword}
   */
  toggleShowPassword () {
    this.showPassword = !this.showPassword;
    console.log(this.showPassword);
  }

}
