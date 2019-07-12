import { Component, OnInit } from '@angular/core';
import { BookingsService } from '../../services/bookings.service';
import {FormBuilder, Validators} from '@angular/forms';
import { RoomService} from '../../services/room.service';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';

@Component({
  selector: 'app-bookings',
  templateUrl: './bookings.component.html',
  styleUrls: ['./bookings.component.css']
})
export class BookingsComponent implements OnInit {

  constructor(private bookingService: BookingsService,
              private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private router: Router,) { }

  heading = 'Bookings';
  bookingsData: any[];
  filterForm: any;
  ngOnInit() {
    this.getBookings();
    this.filterForm = this.formBuilder.group({
        'date': ['', Validators.required]
    });
  }

  getBookings() {
    this.bookingService.getAllBooking().subscribe(data => {
      if (data.status === true) {
        this.bookingsData = data.data;
      }
    },error => {
      console.log(error);
    });
  }

  submitFilterForm() {
    if (this.filterForm.dirty && this.filterForm.valid){
      const date = this.filterForm.value.date;
      const dateArray = date.split('-');
      const year = dateArray[0];
      const month = dateArray[1];
      this.bookingService.getFilteredBooking(parseInt(year), parseInt(month)).subscribe(data => {
        this.bookingsData = data.data;
      }, error => {
        console.log(error);
      });
    }
  }

  deleteBooking(id: number) {
    this.bookingService.deleteBooking(id).subscribe(data => {
      this.router.navigateByUrl('/', {skipLocationChange: true}).then(() =>
        this.router.navigate(['booking']));
      if (data.status === true){
        this.toastr.success(data.message);
      } else {
        this.toastr.error(data.message);
      }
    }, error => {
      console.log(error);
    });
  }
}
