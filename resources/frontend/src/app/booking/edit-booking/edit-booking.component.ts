import { Component, OnInit } from '@angular/core';
import { RoomService} from '../../services/room.service';
import {FormBuilder, Validators} from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {Location} from '@angular/common';
import {BookingsService} from '../../services/bookings.service';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-edit-booking',
  templateUrl: './edit-booking.component.html',
  styleUrls: ['./edit-booking.component.css']
})
export class EditBookingComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private roomService: RoomService,
              private location: Location,
              private route: ActivatedRoute,
              private bookingService: BookingsService) { }
  heading = 'Edit Room';
  editForm: any;
  roomsData: any[];
  ngOnInit() {
    this.editForm = this.formBuilder.group({
      'roomID': ['', Validators.required],
      'startDate': ['', Validators.required],
      'endDate': ['', Validators.required],
      'customerName': ['', Validators.required],
      'customerEmail': ['', Validators.required],
      'totalPrice': ['', Validators.required],
      'totalNights': ['', Validators.required]
    });
    this.setUserInfo();
    this.getRooms();
    this.getBooking();
  }

  setUserInfo() {
    const user = JSON.parse(localStorage.getItem('currentUser'));
    this.editForm.patchValue({
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

  getBooking() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.bookingService.getBooking(id).subscribe(data => {
      this.editForm.patchValue({
        'totalNights': data.data.total_nights,
        'startDate': data.data.start_date,
        'endDate': data.data.end_date,
        'totalPrice': `${data.data.total_price} ${data.data.currency}`,
        'roomID': data.data.room_id
      });
    }, error => {
      console.log(error);
    });
  }

  submitEditForm(){
    if (this.editForm.valid){

      this.editForm.value.totalPrice = this.editForm.value.totalPrice.split(' ')[0];
      this.editForm.value.bookingID = +this.route.snapshot.paramMap.get('id');
      this.bookingService.updateBooking(this.editForm.value).subscribe(data => {
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

  public findValidControls() {
    const invalid = [];
    const controls = this.editForm.controls;
    for (const name in controls) {
      if (controls[name].valid) {
        invalid.push(name);
      }
    }
    return invalid;
  }

  getTotalNightAndPrice() {
    const invalid = this.findValidControls();
    if (invalid.includes('roomID') && invalid.includes('startDate') && invalid.includes('endDate')) {
        const body = {
          'roomID': this.editForm.value.roomID,
          'startDate': this.editForm.value.startDate,
          'endDate': this.editForm.value.endDate
        };
        console.log(body);
        this.bookingService.getTotalValueForBooking(body).subscribe(data => {
          console.log(data);
          this.editForm.patchValue({
            'totalNights': data.data.total_nights,
            'totalPrice': `${data.data.total_price.amount} ${data.data.total_price.currency}`
          });
        }, error => {
          console.log(error);
        });
    } else {
      this.editForm.patchValue({
        'totalNights': '',
        'totalPrice': ''
      });
    }
  }

}
