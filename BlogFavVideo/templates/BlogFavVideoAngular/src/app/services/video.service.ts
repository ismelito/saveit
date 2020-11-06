import{Injectable} from '@angular/core';
import{HttpClient,HttpHeaders} from '@angular/common/http';
import{Observable} from 'rxjs';
import{Video} from '../models/video';
import{global} from '../services/global';
import { stringify } from 'querystring';

@Injectable()
export class VideoService {

    public url:string;
    public identity: string;
    public token: string;


    constructor(
        public _http: HttpClient
    ){
        this.url=global.url
    }

    
    create(video):Observable<any>{
      // serializar el objeto de java script y convertirlo a un json string para poder enviarlo pour http
      const json = JSON.stringify(video);
      
      // meter la informacion dentro de una variable params para poder enviarla por POST
      const params = 'json=' + json;
      // definir el (content-type), la forma en que se enviaran los datos(formato)
      const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

      return this._http.post(this.url + 'create/video', params , { headers : header });

    }

    createVideo(token,video):Observable<any>{
      // serializar el objeto de java script y convertirlo a un json string para poder enviarlo pour http
      const json = JSON.stringify(video);
      console.log('json',json);
      // meter la informacion dentro de una variable params para poder enviarla por POST
      const params = 'json=' + json;
      // definir el (content-type), la forma en que se enviaran los datos(formato)
      const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);

      return this._http.post(this.url + 'create/video', params , { headers : header });

    }
    updateVideo(token,video,id):Observable<any>{
        // serializar el objeto de java script y convertirlo a un json string para poder enviarlo pour http
        const json = JSON.stringify(video);
        
        // meter la informacion dentro de una variable params para poder enviarla por POST
        const params = 'json=' + json;
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);
  
        return this._http.put(this.url + 'update/video/'+id, params , { headers : header });
  
      }

      removeVideos(token,id):Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);
  
        return this._http.delete(this.url + 'remove/video/'+id, { headers : header });
  
      }  
    
    getVideos(token, page):Observable<any>{
      console.log("page",page);
        if(!page){
          page=1;
        }
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);
  
        return this._http.get(this.url + 'list/video/?page='+page, { headers : header });
  
      }
    getVideo(token,id):Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);
  
        return this._http.get(this.url + 'detail/video/'+id, { headers : header });
  
      }
   

   
  

}
