import { Component, OnInit } from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import { RoomService } from '../../services/room.service';
import { HotelService} from '../../services/hotel.service';
import { RoomTypeService} from '../../services/room-type.service';
import {Location} from '@angular/common';

@Component({
  selector: 'app-create-room',
  templateUrl: './create-room.component.html',
  styleUrls: ['./create-room.component.css']
})
export class CreateRoomComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private router: Router,
              private roomService: RoomService,
              private route: ActivatedRoute,
              private location: Location,
              private roomTypeService: RoomTypeService,
              private hotelService: HotelService) { }
  heading = 'Create Room';
  createForm: any;
  selectedFile: File = null;
  roomTypeData: any[];
  hotelData: any[];
  ngOnInit() {
    this.createForm = this.formBuilder.group({
        'roomName': ['', Validators.required],
        'roomTypeID': ['', Validators.required],
        'hotelID': ['', Validators.required],
        'imageFile': ['', Validators.required]
    });
    this.getRoomTypes();
    this.getHotels();
  }

  onFileSelected(event) {
    this.selectedFile = <File>event.target.files[0];
  }

  goBack(): void {
    this.location.back();
  }

  getRoomTypes(){
    this.roomTypeService.getRoomTypes().subscribe(data => {
      this.roomTypeData = data.data;
    }, error => {
      console.log(error);
    });
  }

  getHotels(){
    this.hotelService.getAllHotel().subscribe(data => {
      this.hotelData = data.data;
    }, error => {
      console.log(error);
    });
  }

  submitCreateForm() {
    if (this.createForm.dirty && this.createForm.valid){
      const body = new FormData();
        body.append('image', this.selectedFile, this.selectedFile.name);
        body.append('name', this.createForm.value.roomName);
        body.append('roomTypeID', this.createForm.value.roomTypeID);
        body.append('hotelID', this.createForm.value.hotelID);

        this.roomService.createRoom(body).subscribe(data => {
          if (data.status){
            this.toastr.success(data.message);
          } else{
            this.toastr.error(data.message);
          }
        }, error => {
          console.log(error);
          this.toastr.error(error.message);
        });
    }
  }
}
