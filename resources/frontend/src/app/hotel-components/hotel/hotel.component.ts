import { Component, OnInit } from '@angular/core';

import { HotelService} from '../../services/hotel.service';

@Component({
  selector: 'app-hotel',
  templateUrl: './hotel.component.html',
  styleUrls: ['./hotel.component.css']
})
export class HotelComponent implements OnInit {

  constructor(private hotelService: HotelService) { }
  heading = 'Hotels';
  hotelsData: any[];

  ngOnInit() {
    this.getAllHotels();
  }

  getAllHotels(){
    this.hotelService.getAllHotel().subscribe(data => {
      this.hotelsData = data.data;
    }, err => {
      console.log(err);
    });
  }
}
