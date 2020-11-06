import { Component,OnInit,DoCheck } from '@angular/core';
import{Router,ActivatedRoute,Params} from '@angular/router';
import {UserService} from '../../services/user.services';
import {VideoService} from '../../services/video.service';
import { Subscriber } from 'rxjs';
import { ITS_JUST_ANGULAR } from '@angular/core/src/r3_symbols';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
  providers: [UserService,VideoService]
})
export class HomeComponent implements OnInit {
     public page_title:string;
     public identity;
     public token;
     public videos;
     public page;
     public next_page;
     public prev_page;
     public number_pages;
    
     
     constructor(
      private _router:Router,
      private _route:ActivatedRoute,
      private _userService:UserService,
      private _videoService:VideoService
     ) { 
     this.page_title=" Mes Videos";
     
     }

  ngOnInit(): void {  
   
    this.loadUser();   
    this.currentPageVideo();     
   
  }

  loadUser(){
    this.identity =this._userService.getIdentity();
    this.token =this._userService.getToken();
  }

  currentPageVideo(){
      this._route.params.subscribe(params => {
        let page= +params['page']; //saca el parametro page enviado por url y lo convierte en un string
      
        if(!page){
          page=1;
          this.prev_page=1;
          this.next_page=2;
        }
        
      this.getVideos(page);
        
    });
  }

  getVideos(page){
    this._videoService.getVideos(this.token,page).subscribe (
      response => {
        var videos=[];
        
           this.videos=response.videos;
           
           let number_pages=[];
           for(let i=1;i<=response.total_page;i++){
                number_pages.push(i);
           }  
           this.number_pages=number_pages;

           if(page>=2){
               this.prev_page=page-1;
           }else{
               this.prev_page=1;
           }

           if(page < response.total_page){
               this.next_page=page+1;
           }else{
               this.next_page=response.total_page;
           }
              

           console.log("jfjjfjjfjf",this.videos);
           
      },
      error => {
           console.log(error);
      }
    );
    
  }

  getThumb(url, size) {
    var video, results, thumburl;
    
     if (url === null) {
         return '';
     }
     
     results = url.match('[\\?&]v=([^&#]*)');
     video   = (results === null) ? url : results[1];
    
     if(size != null) {
         thumburl = 'http://img.youtube.com/vi/' + video + '/'+ size +'.jpg';
     }else{
         thumburl = 'http://img.youtube.com/vi/' + video + '/mqdefault.jpg';
     }
    
      return thumburl;
        
    }

    deleteVideo(id) {
      console.log("id",id);
        this._videoService.removeVideos(this.token,id).subscribe(
          response => {
              // si la response est positive on fait l'actualization de videos
              this.currentPageVideo();   
          },
          error => {
               console.log(error);
          }  
        );
          
      }

}
