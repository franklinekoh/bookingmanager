import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import { Location } from '@angular/common';
import { RoomTypeService} from '../../services/room-type.service';

@Component({
  selector: 'app-room-types-create',
  templateUrl: './room-types-create.component.html',
  styleUrls: ['./room-types-create.component.css']
})
export class RoomTypesCreateComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private route: ActivatedRoute,
              private location: Location,
              private toastr: ToastrService,
              private router: Router,
              private roomType: RoomTypeService,) { }

  createForm: any;
  heading = 'Create Room Type';
  ngOnInit() {
    this.createForm = this.formBuilder.group({
      'typeName': ['', Validators.required]
    });
  }

  submitCreateForm() {
    if (this.createForm.dirty && this.createForm.valid){
      this.roomType.createRoomTypes(this.createForm.value).subscribe(data => {
        if (data.status === true) {
          this.toastr.success(data.message);
        } else {
          this.toastr.error(data.message);
        }
      }, error => {
        console.log(error);
        this.toastr.error('Room type creation failed');
      });
    }
  }

}
