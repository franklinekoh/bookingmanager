import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Location} from '@angular/common';
import {ToastrService} from 'ngx-toastr';
import {PriceService} from '../../services/price.service';
import {FormBuilder, Validators} from '@angular/forms';
import {RoomTypeService} from '../../services/room-type.service';

@Component({
  selector: 'app-edit-price',
  templateUrl: './edit-price.component.html',
  styleUrls: ['./edit-price.component.css']
})
export class EditPriceComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private location: Location,
    private toastr: ToastrService,
    private price: PriceService,
    private formBuilder: FormBuilder,
    private roomType: RoomTypeService,
  ) {}

  heading = 'Edit Price';
  roomTypesData: any[];
  editForm: any;
  priceDetail: any;
  ngOnInit() {
    this.editForm = this.formBuilder.group({
      'amount': ['', Validators.required],
      'currency': ['', Validators.required],
      'roomTypeID': ['', Validators.required]
    });
      this.getRoomType();
      this.getPriceDetail();
  }

  submitEditForm() {
    if (this.editForm.valid) {
      const id = +this.route.snapshot.paramMap.get('id');
        this.price.editPrice({
          'priceID': id,
          'amount': this.editForm.value.amount,
          'currency': this.editForm.value.currency,
          'roomTypeID': this.editForm.value.roomTypeID
        }).subscribe(data => {
          this.toastr.success(data.message);
        }, error => {
          this.toastr.error(error.message);
        });
    }
  }

  getRoomType() {
    this.roomType.getRoomTypes().subscribe(data => {
      this.roomTypesData = data.data;
    },error => {
      console.log(error);
    });
  }
  getPriceDetail() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.price.getPriceByID(id).subscribe(data => {
      this.priceDetail = data.data;
      this.editForm.patchValue({
        'amount': data.data.amount,
        'currency': data.data.currency,
        'roomTypeID': data.data.room_type_id
      });
    }, error => {
      console.log(error);
    });
  }
}
