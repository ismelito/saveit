import { Component, OnInit } from '@angular/core';
import{Router,ActivatedRoute,Params} from '@angular/router';// import para la navegation
import{Video} from '../../models/video';
import{UserService} from '../../services/user.services';
import{VideoService} from '../../services/video.service';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';


@Component({
  selector: 'app-video-detail',
  templateUrl: './video-detail.component.html',
  styleUrls: ['./video-detail.component.css'],
  providers:[UserService,VideoService]
})
export class VideoDetailComponent implements OnInit {

  
  public status:string;
  public identity;
  public token;
  public idSelect;
  public video:Video;
  constructor(
     private _router:Router,
     private _route:ActivatedRoute,
     private _userService:UserService,
     private _videoService:VideoService,
     private _sanitizer: DomSanitizer

  ) { 
     
     this.identity=_userService.getIdentity();
     this.token=_userService.getToken(); 
     }

     ngOnInit(): void {
      
      this.getVideo();
  
      console.log("ffff",this.identity);
    }
  
    getVideo(){
      this._route.params.subscribe(
       params => {
           let id= +params['id'];
           this.idSelect=id;
           this._videoService.getVideo(this.token,id).subscribe(
               response => {
                 console.log("response",response);
                 
                   if(response.status=='success'){
                      
                      this.video=response;
                      console.log("this.video",this.video);
                   }else{
                      this._router.navigate(['/home']);
                   }
               },              
               error=> {
                   console.log(error);
                   this.status=error;
               },
           );
       });
  
  }
 /**
  * Consigue (id)  el identificador del video de de la url de youtube
  * @param url 
  */
  getVideoIframe(url) {
    var video, results;
 
    if (url === null) {
        return '';
    }
    results = url.match('[\\?&]v=([^&#]*)'); //Consigue (id)  el identificador del video de de la url de youtube
    video   = (results === null) ? url : results[1];
     //limpia la url y le pasamos el id del video
    return this._sanitizer.bypassSecurityTrustResourceUrl('https://www.youtube.com/embed/' + video);   
}


}
