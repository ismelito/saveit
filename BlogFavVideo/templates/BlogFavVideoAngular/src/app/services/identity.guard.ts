import{Injectable} from '@angular/core';
import{Router,ActivatedRoute,Params, CanActivate} from '@angular/router';
import{UserService} from '../services/user.services';


@Injectable()
export class IdentityGuard implements CanActivate {

    constructor(
        private _route:Router,
        private _userService:UserService
    ){

    }
    canActivate() {
        let identity=this._userService.getIdentity();
        if(identity){
           return true;
        }else{
            this._route.navigate(['/login']);
            return false;
        }
    
    }
}
