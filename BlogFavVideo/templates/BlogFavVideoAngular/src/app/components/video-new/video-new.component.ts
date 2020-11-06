import { Component, OnInit } from '@angular/core';
import{Router,ActivatedRoute,Params} from '@angular/router';// import para la navegation
import{Video} from '../../models/video';
import{UserService} from '../../services/user.services';
import{VideoService} from '../../services/video.service';
import{SatelitetableService} from '../../services/satelitetable.services';

@Component({
  selector: 'app-video-new',
  templateUrl: './video-new.component.html',
  styleUrls: ['./video-new.component.css'],
  providers: [UserService,VideoService,SatelitetableService]
})
export class VideoNewComponent implements OnInit {

  public page_title:string;
  public status:string;
  public identity;
  public token;
  public video:Video;
  public videoStatus;
  
  constructor(
     private _router:Router,
     private _route:ActivatedRoute,
     private _userService:UserService,
     private _videoService:VideoService,
     private _satelitetableService:SatelitetableService
  ) { 
     this.page_title=" Enregistrer une vidéo préférée";
     this.identity=_userService.getIdentity();
     this.token=_userService.getToken(); 
     }

  ngOnInit(): void {
    this.video= new Video("","","","");
    this.sateliteTable();

    console.log("ffff",this.identity);
  }

  onSubmit(form){
    console.log(this.video);
    this._videoService.createVideo(this.token,this.video).subscribe(
      response => {

            if(response.status=='success'){
               this.status='success';
               this._router.navigate(['/home']);
            }else{
              this.status='error';
            }
            console.log('response',response);
      },
      error =>{
            this.status='error';
            console.log('error1',error);    
            console.log('22222222',this.status);     
      }
    );

  }
sateliteTable(){
    this._satelitetableService.getVideoStatus().subscribe(
      response=>{
        
          if(response.status=="success"){
              //this.status="success";
              this.videoStatus=response.videoStatus;
              console.log("this.videoStatus",this.videoStatus);
              
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
