import { Component, OnInit } from '@angular/core';
import { RoomService} from '../../services/room.service';
import {FormBuilder, Validators} from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import {Location} from '@angular/common';
import {BookingsService} from '../../services/bookings.service';

@Component({
  selector: 'app-create-booking',
  templateUrl: './create-booking.component.html',
  styleUrls: ['./create-booking.component.css']
})
export class CreateBookingComponent implements OnInit {

  constructor(
    private formBuilder: FormBuilder,
    private toastr: ToastrService,
    private roomService: RoomService,
    private location: Location,
    private bookingService: BookingsService) { }

  heading = 'Create Rooms';
  roomsData: any[];
  createRoom: any;
  ngOnInit() {
    this.getRooms();
    this.createRoom = this.formBuilder.group({
      'roomID': ['', Validators.required],
      'startDate': ['', Validators.required],
      'endDate': ['', Validators.required],
      'customerName': ['', Validators.required],
      'customerEmail': ['', Validators.required],
      'totalPrice': ['', Validators.required],
      'totalNights': ['', Validators.required]
    });
    this.setUserInfo();
  }

  setUserInfo() {
    const user = JSON.parse(localStorage.getItem('currentUser'));
    this.createRoom.patchValue({
      'customerName': user.fullname,
      'customerEmail': user.email
    });
  }

  getRooms() {
    this.roomService.getAvailableRooms().subscribe(data => {
      this.roomsData = data.data;
    }, error => {
      console.log(error);
    });
  }

  goBack(): void {
    this.location.back();
  }

  submitCreateForm(){

    if (this.createRoom.valid){

      this.createRoom.value.totalPrice = this.createRoom.value.totalPrice.split(' ')[0];
      this.bookingService.createBooking(this.createRoom.value).subscribe(data => {
            if (data.status === true){
              this.toastr.success(data.message);
            } else {
              this.toastr.error(data.message);
            }
      }, error => {
        console.log(error);
        this.toastr.error(error.message);
      });
    }
  }

  getTotalNightAndPrice() {
    let invalid = this.findInvalidControls();
    if (!invalid.includes('roomID') && !invalid.includes('startDate') && !invalid.includes('endDate') ) {
        const body = {
          'roomID': this.createRoom.value.roomID,
          'startDate': this.createRoom.value.startDate,
          'endDate': this.createRoom.value.endDate
        };
        this.bookingService.getTotalValueForBooking(body).subscribe(data => {
          this.createRoom.patchValue({
            'totalNights': data.data.total_nights,
            'totalPrice': `${data.data.total_price.amount} ${data.data.total_price.currency}`
          });
        }, error => {
          console.log(error);
        });
    } else {
      this.createRoom.patchValue({
        'totalNights': '',
        'totalPrice': ''
      });
    }
  }

  public findInvalidControls() {
    const invalid = [];
    const controls = this.createRoom.controls;
    for (const name in controls) {
      if (controls[name].invalid) {
        invalid.push(name);
      }
    }
    return invalid;
  }
}
