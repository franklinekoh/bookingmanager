import { Component, OnInit } from '@angular/core';
import {BookingsService} from '../../services/bookings.service';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';

@Component({
  selector: 'app-view-booking',
  templateUrl: './view-booking.component.html',
  styleUrls: ['./view-booking.component.css']
})
export class ViewBookingComponent implements OnInit {

  constructor(
    private bookingService: BookingsService,
    private route: ActivatedRoute,
    private location: Location
  ) { }
  heading = 'View Bookings';
  bookingData: any;
  ngOnInit() {
    this.getBooking();
  }

  getBooking() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.bookingService.getBooking(id).subscribe(data => {
      this.bookingData = data.data;
    }, error => {
      console.log(error);
    });
  }

  goBack(): void {
    this.location.back();
  }

}
