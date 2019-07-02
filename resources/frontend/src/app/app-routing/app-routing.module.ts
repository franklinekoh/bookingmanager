import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes} from '@angular/router';
import { AuthGaurdService as AuthGuard } from '../services/auth-gaurd.service';

import { HeaderComponent } from '../header/header.component';
import {  LoginComponent} from '../login/login.component';



const routes: Routes = [

  { path: 'header', component: HeaderComponent, canActivate: [AuthGuard]},
  { path: 'login', component: LoginComponent}

];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(
      routes,
      // { enableTracing: true } // <-- debugging purposes only
    )
  ],
  exports: [ RouterModule ],
  declarations: []
})
export class AppRoutingModule { }
