import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { HeaderComponent } from './layouts/header/header.component';
import { AppRoutingModule } from './app-routing/app-routing.module';
import { FooterComponent } from './layouts/footer/footer.component';
import { PageTitleComponent } from './page-title/page-title.component';
import { HotelComponent } from './hotel-components/hotel/hotel.component';
import { LoginComponent } from './login/login.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ToastrModule } from 'ngx-toastr';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { JwtModule } from '@auth0/angular-jwt';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { HotelDetailsComponent } from './hotel-components/hotel-details/hotel-details.component';
import { EditHotelComponent } from './hotel-components/edit-hotel/edit-hotel.component';
import { PricesComponent } from './price/prices/prices.component';
import { CreatePriceComponent } from './price/create-price/create-price.component';
import { ViewPriceComponent } from './price/view-price/view-price.component';
import { EditPriceComponent } from './price/edit-price/edit-price.component';
import { RoomTypesComponent } from './room/room-types/room-types.component';
import { RoomTypesCreateComponent } from './room/room-types-create/room-types-create.component';
import { EditRoomTypeComponent } from './room/edit-room-type/edit-room-type.component';
import { ViewRoomTypeComponent } from './room/view-room-type/view-room-type.component';
import { RoomsComponent } from './room/rooms/rooms.component';
import { CreateRoomComponent } from './room/create-room/create-room.component';
import { ViewRoomComponent } from './room/view-room/view-room.component';
import { EditRoomComponent } from './room/edit-room/edit-room.component';
import { BookingsComponent } from './booking/bookings/bookings.component';
import { CreateBookingComponent } from './booking/create-booking/create-booking.component';
import { ViewBookingComponent } from './booking/view-booking/view-booking.component';
import { EditBookingComponent } from './booking/edit-booking/edit-booking.component';

export function tokenGetter() {
  return localStorage.getItem('authToken');
}

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    PageTitleComponent,
    HotelComponent,
    LoginComponent,
    PageNotFoundComponent,
    HotelDetailsComponent,
    EditHotelComponent,
    PricesComponent,
    CreatePriceComponent,
    ViewPriceComponent,
    EditPriceComponent,
    RoomTypesComponent,
    RoomTypesCreateComponent,
    EditRoomTypeComponent,
    ViewRoomTypeComponent,
    RoomsComponent,
    CreateRoomComponent,
    ViewRoomComponent,
    EditRoomComponent,
    BookingsComponent,
    CreateBookingComponent,
    ViewBookingComponent,
    EditBookingComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot(),
    HttpClientModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: tokenGetter,
        whitelistedDomains: ['localhost:8000'],
        blacklistedRoutes: ['']
      }
    }),
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
