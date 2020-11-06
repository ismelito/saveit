import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import{HttpClientModule} from '@angular/common/http';
import { routing,appRoutingProviders } from './app.routing';
import {FormsModule} from '@angular/forms';

import { AppComponent } from './app.component';
import { HomeComponent } from './components/home/home.component';
import { LoginComponent } from './components/login/login.component';
import { RegisterComponent } from './components/register/register.component';
import { ErrorComponent } from './components/error/error.component';
import { UserEditComponent } from './components/user-edit/user-edit.component';
import { VideoNewComponent } from './components/video-new/video-new.component';

import{IdentityGuard} from './services/identity.guard';
import{UserService} from './services/user.services';
import { VideoEditComponent } from './components/video-edit/video-edit.component';
import { VideoDetailComponent } from './components/video-detail/video-detail.component';
import { AboutComponent } from './components/about/about.component';
import { ContactComponent } from './components/contact/contact.component';


@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    LoginComponent,
    RegisterComponent,
    ErrorComponent,
    UserEditComponent,
    VideoNewComponent,
    VideoEditComponent,
    VideoDetailComponent,
    AboutComponent,
    ContactComponent
  ],
  imports: [
    BrowserModule,
    routing,
    HttpClientModule,
    FormsModule
  ],
  providers: [
    appRoutingProviders,
    IdentityGuard,
    UserService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
