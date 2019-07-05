import { Component, OnInit } from '@angular/core';
import { HotelService} from '../../services/hotel.service';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-hotel-details',
  templateUrl: './hotel-details.component.html',
  styleUrls: ['./hotel-details.component.css']
})
export class HotelDetailsComponent implements OnInit {

  constructor(private hotelService: HotelService,
              private route: ActivatedRoute,
              private location: Location) { }
  hotelData: any;
  heading = `Hotel Details`;
  ngOnInit() {
    this.getHotel();
  }

  getHotel() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.hotelService.getHotel(id).subscribe(data => {
      console.log(data);
      this.hotelData = data.data;
    }, err => {
      console.log(err);
    });
  }

}
