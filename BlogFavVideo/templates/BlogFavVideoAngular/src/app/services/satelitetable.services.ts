import{Injectable} from '@angular/core';
import{HttpClient,HttpHeaders} from '@angular/common/http';
import{Observable} from 'rxjs';

import{global} from '../services/global';
import { stringify } from 'querystring';

@Injectable()
export class SatelitetableService {

    public url:string;
    public identity: string;
    public token: string;


    constructor(
        public _http: HttpClient
    ){
        this.url=global.url
    }

    // administration de l'application
    /*
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
    */
    
      getTypesTelephones():Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.get(this.url + 'select/type-telephone', { headers : header });
  
      }
      getSex():Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.get(this.url + 'select/sex', { headers : header });
  
      }

      getNationality():Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.get(this.url + 'select/nationality', { headers : header });
  
      }

      getMaritalStatus():Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.get(this.url + 'select/maritalStatus', { headers : header });
  
      }

      getVideoStatus():Observable<any>{
        
        // definir el (content-type), la forma en que se enviaran los datos(formato)
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.get(this.url + 'select/videoStatus', { headers : header });
  
      }
}
