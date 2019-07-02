import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes, CanActivate} from '@angular/router';

import { HeaderComponent } from '../header/header.component';
import {  LoginComponent} from '../login/login.component';


const routes: Routes = [

  { path: 'header', component: HeaderComponent},
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
