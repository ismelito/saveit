import { Component, OnInit } from '@angular/core';
import{Router,ActivatedRoute,Params} from '@angular/router';// import para la navegation
import{Video} from '../../models/video';
import{UserService} from '../../services/user.services';
import{VideoService} from '../../services/video.service';
import{SatelitetableService} from '../../services/satelitetable.services';

@Component({
  selector: 'app-video-edit',
  templateUrl: '../video-new/video-new.component.html',
  styleUrls: ['./video-edit.component.css'],
  providers: [UserService,VideoService,SatelitetableService]
})
export class VideoEditComponent implements OnInit {

  
  public page_title:string;
  public status:string;
  public identity;
  public token;
  public idSelect;
  public video:Video;
  public videoStatus;

  constructor(
    // injection de services dans la component
     private _router:Router,
     private _route:ActivatedRoute,
     private _userService:UserService,
     private _videoService:VideoService,
     private _satelitetableService:SatelitetableService
  ) { 
     this.page_title=" Modifier votre vidéo préférée";
     this.identity=_userService.getIdentity();
     this.token=_userService.getToken(); 
     }

  ngOnInit(): void {
    this.video= new Video("","","","");
    this.getVideo();
    this.sateliteTable();

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

  onSubmit(form){
    console.log(this.video);
    this._videoService.updateVideo(this.token,this.video,this.idSelect).subscribe(
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
