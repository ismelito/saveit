import { Component, OnInit } from '@angular/core';
import{User} from '../../models/user';
import{UserService} from '../../services/user.services';
import{SatelitetableService} from '../../services/satelitetable.services';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.css'],
  providers:[UserService,SatelitetableService]
})
export class UserEditComponent implements OnInit {
 
    public page_title:string;
    public status:string;
    public user:User;
    public identity;
    public token;
    public typeTelephone;
    public Sex;
    public Nationality;
    public MaritalStatus;

  constructor(
     private _userservice:UserService,
     private _satelitetableService:SatelitetableService
  ) { 
     this.identity=this._userservice.getIdentity();
     this.token=this._userservice.getToken();
     this.page_title=" Paramètres de l'utilisateur";
     this.user= new User(this.identity.name,
                         this.identity.lastname,
                         this.identity.birthday,
                         this.identity.maritalstatus,
                         this.identity.sex,
                         this.identity.nationality,
                         this.identity.type_telephone,
                         this.identity.telephone,
                         this.identity.email,
                         ""
                         );
  }

  ngOnInit(): void {
    this.sateliteTable();
  }

  onSubmit(form){
    this._userservice.update(this.token,this.user).subscribe(
      response=>{
       
          if(response.status=="success"){
               this.status="success";
               //form.reset();
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
              //this.status="success";
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
              //this.status="success";
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
              //this.status="success";
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
              //this.status="success";
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

}
