import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import { Location } from '@angular/common';
import { RoomTypeService} from '../../services/room-type.service';
import { FormBuilder, Validators } from '@angular/forms';
import {error} from 'selenium-webdriver';
import {ToastrService} from 'ngx-toastr';

@Component({
  selector: 'app-edit-room-type',
  templateUrl: './edit-room-type.component.html',
  styleUrls: ['./edit-room-type.component.css']
})
export class EditRoomTypeComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private location: Location,
    private roomType: RoomTypeService,
    private formBuilder: FormBuilder,
    private toastr: ToastrService,
  ) { }
  editForm: any;
  roomTypeData: any;
  heading = 'Edit Room Type';

  ngOnInit() {
    this.editForm = this.formBuilder.group({
      'typeName': ['', Validators.required]
    });
    this.getRoomType();
  }

  submitEditForm() {
    if (this.editForm.valid){
      const id = +this.route.snapshot.paramMap.get('id');
      console.log(this.editForm.value);
      this.roomType.updateRoomTypes({
        'roomTypeID': id,
        'type_name': this.editForm.value.typeName
      }).subscribe(data => {
        if (data.status === true) {
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
  getRoomType() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.roomType.getRoomTypeByID(id).subscribe(data => {
      this.roomTypeData = data.data;
      this.editForm.patchValue({
        'typeName': data.data.type_name
      });
    }, error => {
      console.log(error);
    });
  }

}
