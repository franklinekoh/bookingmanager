import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes} from '@angular/router';
import { AuthGaurdService as AuthGuard } from '../services/auth-gaurd.service';

import { LoginComponent } from '../login/login.component';
import { PageNotFoundComponent } from '../page-not-found/page-not-found.component';
import { HotelComponent } from '../hotel/hotel.component';
import { HotelDetailsComponent} from '../hotel-details/hotel-details.component';
import { EditHotelComponent } from '../edit-hotel/edit-hotel.component';
import { PricesComponent } from '../price/prices/prices.component';
import { CreatePriceComponent} from '../price/create-price/create-price.component';


const routes: Routes = [
  { path: 'login', component: LoginComponent},
  { path: 'hotel', component: HotelComponent, canActivate: [AuthGuard]},
  { path: 'hotel/:id', component: HotelDetailsComponent, canActivate: [AuthGuard]},
  { path: 'hotel/edit/:id', component: EditHotelComponent, canActivate: [AuthGuard]},
  { path: 'price', component: PricesComponent, canActivate: [AuthGuard]},
  { path: 'price/create', component: CreatePriceComponent, canActivate: [AuthGuard]},
  { path: '', redirectTo: 'hotel', pathMatch: 'full'},
  { path: '**', component: PageNotFoundComponent},

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
