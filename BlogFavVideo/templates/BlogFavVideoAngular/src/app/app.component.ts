import { Component,OnInit,DoCheck } from '@angular/core';
import{UserService}from './services/user.services'

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [UserService]
})
export class AppComponent implements OnInit, DoCheck {
  title = 'Application de vidéos favorites';
  public identity;
  public token;
  
  constructor(
    private _userService:UserService,
  ){
  
  }
  
  ngOnInit(){
   
  }

  ngDoCheck() {
    this.loadUser();
    console.log(this.identity);
  }
  
  loadUser(){
    this.identity =this._userService.getIdentity();
    this.token =this._userService.getToken();
  }
}

