import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import { Location } from '@angular/common';
import { RoomTypeService} from '../../services/room-type.service';
import { PriceService } from '../../services/price.service';

@Component({
  selector: 'app-create-price',
  templateUrl: './create-price.component.html',
  styleUrls: ['./create-price.component.css']
})
export class CreatePriceComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private route: ActivatedRoute,
              private location: Location,
              private toastr: ToastrService,
              private router: Router,
              private roomType: RoomTypeService,
              private price: PriceService) {}
  heading = 'Creat Price';
  createForm: any;
  roomTypesData: any;
  ngOnInit() {
    this.createForm = this.formBuilder.group({
      'amount': ['', Validators.required],
      'currency': ['', Validators.required],
      'roomTypeID': ['', Validators.required]
    });
    this.getRoomType();
  }

  submitCreateForm() {
    if (this.createForm.dirty && this.createForm.valid) {
      this.price.createPrice(this.createForm.value).subscribe(data => {
          if (data.status === true) {
            this.toastr.success(data.message);
          }
      }, error => {
          this.toastr.error(error.error.message);
      });
    }
  }

  goBack(): void {
    this.location.back();
  }
  getRoomType() {
    this.roomType.getRoomTypes().subscribe(data => {
      this.roomTypesData = data.data;
      console.log(data);
    },error => {
      console.log(error);
    });
  }

}
