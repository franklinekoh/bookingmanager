import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes} from '@angular/router';
import { AuthGaurdService as AuthGuard } from '../services/auth-gaurd.service';

import { LoginComponent } from '../login/login.component';
import { PageNotFoundComponent } from '../page-not-found/page-not-found.component';
import { HotelComponent } from '../hotel-components/hotel/hotel.component';
import { HotelDetailsComponent} from '../hotel-components/hotel-details/hotel-details.component';
import { EditHotelComponent } from '../hotel-components/edit-hotel/edit-hotel.component';
import { PricesComponent } from '../price/prices/prices.component';
import { CreatePriceComponent} from '../price/create-price/create-price.component';
import { ViewPriceComponent } from '../price/view-price/view-price.component';
import { EditPriceComponent } from '../price/edit-price/edit-price.component';
import { RoomTypesComponent } from '../room/room-types/room-types.component';
import { RoomTypesCreateComponent } from '../room/room-types-create/room-types-create.component';
import { ViewRoomTypeComponent } from '../room/view-room-type/view-room-type.component';
import { EditRoomTypeComponent } from '../room/edit-room-type/edit-room-type.component';
import { RoomsComponent} from '../room/rooms/rooms.component';
import { CreateRoomComponent } from '../room/create-room/create-room.component';
import { ViewRoomComponent} from '../room/view-room/view-room.component';
import { EditRoomComponent} from '../room/edit-room/edit-room.component';
import { BookingsComponent } from '../booking/bookings/bookings.component';
import { CreateBookingComponent } from '../booking/create-booking/create-booking.component';
import { ViewBookingComponent } from '../booking/view-booking/view-booking.component';


const routes: Routes = [
  { path: 'login', component: LoginComponent},
  { path: 'hotel', component: HotelComponent, canActivate: [AuthGuard]},
  { path: 'hotel/:id', component: HotelDetailsComponent, canActivate: [AuthGuard]},
  { path: 'hotel/edit/:id', component: EditHotelComponent, canActivate: [AuthGuard]},
  { path: 'price', component: PricesComponent, canActivate: [AuthGuard]},
  { path: 'price/create', component: CreatePriceComponent, canActivate: [AuthGuard]},
  { path: 'price/:id', component: ViewPriceComponent, canActivate: [AuthGuard]},
  { path: 'price/edit/:id', component: EditPriceComponent, canActivate: [AuthGuard]},
  { path: 'room', component: RoomsComponent, canActivate: [AuthGuard]},
  { path: 'room/create', component: CreateRoomComponent, canActivate: [AuthGuard]},
  { path: 'room/type', component: RoomTypesComponent, canActivate: [AuthGuard]},
  { path: 'room/type/create', component: RoomTypesCreateComponent, canActivate: [AuthGuard]},
  { path: 'room/type/:id', component: ViewRoomTypeComponent, canActivate: [AuthGuard]},
  { path: 'room/:id', component: ViewRoomComponent, canActivate: [AuthGuard]},
  { path: 'room/type/edit/:id', component: EditRoomTypeComponent, canActivate: [AuthGuard]},
  { path: 'room/edit/:id', component: EditRoomComponent, canActivate: [AuthGuard]},
  { path: 'booking', component: BookingsComponent, canActivate: [AuthGuard]},
  { path: 'booking/create', component: CreateBookingComponent, canActivate: [AuthGuard]},
  { path: 'booking/:id', component: ViewBookingComponent, canActivate: [AuthGuard]},
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
