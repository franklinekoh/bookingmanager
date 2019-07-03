import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import {HotelService} from '../services/hotel.service';
import { Location } from '@angular/common';

@Component({
  selector: 'app-edit-hotel',
  templateUrl: './edit-hotel.component.html',
  styleUrls: ['./edit-hotel.component.css']
})
export class EditHotelComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private router: Router,
              private hotelService: HotelService,
              private route: ActivatedRoute,
              private location: Location
              ) {
    this.editForm = this.formBuilder.group({
      'name': [''],
      'address': [''],
      'city': [''],
      'state': [''],
      'country': [''],
      'zipcode': [''],
      'phone': [''],
      'email': ['', Validators.email],
      // 'imageFile': ['']
    });
  }
  heading = 'Edit Hotel';
  editForm: any;
  hotelName: string;

  ngOnInit() {
    this.getHotel();
  }

  getHotel() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.hotelService.getHotel(id).subscribe(data => {
      console.log(data);
      this.hotelName = data.data.name;
      this.editForm.patchValue({
        'name': data.data.name,
        'address': data.data.address,
        'city': data.data.city,
        'state': data.data.state,
        'country': data.data.country,
        'zipcode': data.data.zipcode,
        'phone': data.data.phone,
        'email': data.data.email
      });
    }, err => {
      console.log(err);
    });
  }



  submitEditForm() {
    if (this.editForm.valid) {
      const id = +this.route.snapshot.paramMap.get('id');
      const data = this.editForm.value
      const body = {
        'hotelID': id,
        'data': data
      };
      this.hotelService.editHotel(body).subscribe(data => {
        console.log(data);
        if (data.status === true) {
          this.toastr.success(data.message);
        }

      }, err => {
        console.log(err);
        this.toastr.error('An error Occured');
      });
    }
  }

  goBack(): void {
    this.location.back();
  }

}
