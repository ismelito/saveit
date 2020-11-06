import{ModuleWithProviders} from '@angular/core';
import{Routes, RouterModule} from '@angular/router'; // acceso a todos los objetos y funcionalidades del router
import{IdentityGuard} from './services/identity.guard';

//importar los diferentes componentes
import {LoginComponent} from './components/login/login.component';
import {RegisterComponent} from './components/register/register.component';
import {ErrorComponent} from './components/error/error.component';
import {HomeComponent} from './components/home/home.component'; 
import {UserEditComponent} from './components/user-edit/user-edit.component'; 
import {VideoNewComponent} from './components/video-new/video-new.component'; 
import {VideoEditComponent} from './components/video-edit/video-edit.component'; 
import {VideoDetailComponent} from './components/video-detail/video-detail.component'; 
import {AboutComponent} from './components/about/about.component'; 
import {ContactComponent} from './components/contact/contact.component';

//definir las rutas  dentro de una constante con formato json

const appRoutes:Routes=[
    {path: '', component:LoginComponent},
    {path:'home',component:HomeComponent},
    {path:'home/:page',component:HomeComponent},
    {path:'login', component:LoginComponent},
    {path:'logout/:sure', component:LoginComponent},
    {path:'setting', component:UserEditComponent, canActivate:[IdentityGuard]},
    {path:'video-new', component:VideoNewComponent,canActivate:[IdentityGuard]},
    {path:'video-edit/:id', component:VideoEditComponent,canActivate:[IdentityGuard]},
    {path:'video-detail/:id', component:VideoDetailComponent,canActivate:[IdentityGuard]},
    {path:'about', component:AboutComponent,canActivate:[IdentityGuard]},
    {path:'contact', component:ContactComponent,canActivate:[IdentityGuard]},
    {path:'register',component:RegisterComponent},
    {path:'error',component:ErrorComponent},
    {path:'**',component:ErrorComponent},//cuando no encuentre ninguna ruta 
];

//exportar la configuracion

export const appRoutingProviders:any[]=[];
export const routing:ModuleWithProviders =RouterModule.forRoot(appRoutes);
