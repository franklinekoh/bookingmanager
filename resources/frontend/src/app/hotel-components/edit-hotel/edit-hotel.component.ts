import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import {HotelService} from '../../services/hotel.service';
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
  }
  heading = 'Edit Hotel';
  editForm: any;
  hotelName: string;
  selectedFile: File = null;

  ngOnInit() {
    this.getHotel();
    this.editForm = this.formBuilder.group({
      'name': [''],
      'address': [''],
      'city': [''],
      'state': [''],
      'country': [''],
      'zipcode': [''],
      'phone': [''],
      'email': ['', Validators.email],
      'imageFile': [''],
    });
  }

  getHotel() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.hotelService.getHotel(id).subscribe(data => {
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

  onFileSelected(event) {
    this.selectedFile = <File>event.target.files[0];
  }


  submitEditForm() {
    if (this.editForm.valid) {
      const id = +this.route.snapshot.paramMap.get('id');
      const body = new FormData();
      if (this.selectedFile !== null) {
        body.append('image', this.selectedFile, this.selectedFile.name);
      }
      body.append('hotelID', `${id}`);
      body.append('name', this.editForm.value.name);
      body.append('address', this.editForm.value.address);
      body.append('city', this.editForm.value.city);
      body.append('state', this.editForm.value.state);
      body.append('country', this.editForm.value.country);
      body.append('zipcode', this.editForm.value.zipcode);
      body.append('phone', this.editForm.value.phone);
      body.append('email', this.editForm.value.email);
      this.hotelService.editHotel(body).subscribe(data => {
        if (data.status === true) {
          this.toastr.success(data.message);
        }

      }, err => {
        console.log(err);
        this.toastr.error('An error Occured');
      });
    }
  }


}
