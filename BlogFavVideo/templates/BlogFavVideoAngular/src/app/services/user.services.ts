import{Injectable} from '@angular/core'; // importer l'obj injectable
import{HttpClient,HttpHeaders} from '@angular/common/http';  // importer l'obj injectable pour faire demandes ajax
import{Observable} from 'rxjs';
import{User} from '../models/user';
import{global} from '../services/global';
import { stringify } from 'querystring';

//Ce décorateur @Injectable() permet d'utiliser le service sans avoir à créer 
//une instance à chaque fois que l'on veut l'utiliser
@Injectable()
export class UserService {

    public url:string;
    public identity: string;
    public token: string;


    constructor(
        public _http: HttpClient
    ){
        this.url=global.url
    }

   /*
   * La méthode renvoie un observable de tout type afin que nous ne soyons
   * pas obligés d'avoir les données provenant de l'api d'un type spécifique
   */ 
    register(user):Observable<any>{
      // serializar el objeto de java script y convertirlo a un json string para poder enviarlo por http
      const json = JSON.stringify(user);
      
      // meter la informacion dentro de una variable params para poder enviarla por POST
      const params = 'json=' + json;
      // definir el (content-type), la forma en que se enviaran los datos(formato)
      const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

      return this._http.post(this.url + 'create/user', params , { headers : header });

    }

    update(token,user):Observable<any>{
      // serializar el objeto de java script y convertirlo a un json string para poder enviarlo pour http
      const json = JSON.stringify(user);
      
      // meter la informacion dentro de una variable params para poder enviarla por POST
      const params = 'json=' + json;
      // definir el (content-type), la forma en que se enviaran los datos(formato)
      const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded').set('Authorization',token);

      return this._http.put(this.url + 'update/user', params , { headers : header });

    }

    signup(user, gettoken = null): Observable<any>{

        if ( gettoken != null){
          user.gettoken = 'true';
        }
        const json = JSON.stringify(user);
        const params = 'json=' + json;
        const header = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
  
        return this._http.post(this.url + 'login/user', params, { headers : header});
      }

    /**
     * Funcion que permite Sacar el identity del localStorage y pasarlo a un objeto java script
     */
  
      getIdentity(){
        // Sacar el identity del localStorage y pasarlo a un objeto java script
        const identity = JSON.parse(localStorage.getItem( 'identity' ));
        if (identity && identity !== 'undefine'){
            this.identity = identity;
        }else{
          this.identity = null;
        }
        return this.identity;
      }
    /**
     * Funcion que permite Sacar el token del localStorage y pasarlo a un objeto java script
     */
      getToken(){
        // Sacar el token del localStorage 
        const token = localStorage.getItem( 'token' );
        if (token && token !== 'undefine'){
            this.token = token;
        }else{
          this.token = null;
        }
        return this.token;
      }
  

}
