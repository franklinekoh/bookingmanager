import { Component, OnInit } from '@angular/core';
import {FormBuilder, Validators} from '@angular/forms';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import {RoomService} from '../../services/room.service';
import {Location} from '@angular/common';
import {HotelService} from '../../services/hotel.service';
import {RoomTypeService} from '../../services/room-type.service';

@Component({
  selector: 'app-edit-room',
  templateUrl: './edit-room.component.html',
  styleUrls: ['./edit-room.component.css']
})
export class EditRoomComponent implements OnInit {

  constructor(private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private router: Router,
              private roomService: RoomService,
              private route: ActivatedRoute,
              private roomTypeService: RoomTypeService,
              private location: Location,
              private hotelService: HotelService) { }
  heading = 'Edit Room';
  editForm: any;
  selectedFile: File = null;
  roomTypeData: any[];
  roomData: any;
  hotelData: any[];
  ngOnInit() {
    this.editForm = this.formBuilder.group({
      'roomName': ['', Validators.required],
      'roomTypeID': ['', Validators.required],
      'hotelID': ['', Validators.required],
      'imageFile': ['']
    });
    this.getRoom();
    this.getHotel();
    this.getRoomTypes();
  }

  onFileSelected(event) {
    this.selectedFile = <File>event.target.files[0];
  }

  getRoom(){
    const id = +this.route.snapshot.paramMap.get('id');
    this.roomService.getRoomByID(id).subscribe(data => {
      this.roomData = data.data;
      this.editForm.patchValue({
        'roomName': data.data.room_name,
        'roomTypeID': data.data.room_type_id,
        'hotelID': data.data.hotel_id
      });
    }, error => {
      console.log(error);
    });
  }

  getHotel(){
    this.hotelService.getAllHotel().subscribe(data => {
      this.hotelData = data.data;
    }, error => {
      console.log(error);
    });
  }

  getRoomTypes(){
    this.roomTypeService.getRoomTypes().subscribe(data => {
      this.roomTypeData = data.data;
    }, error => {
      console.log(error);
    });
  }

  submitEditForm() {
    if (this.editForm.valid){
      const id = +this.route.snapshot.paramMap.get('id');
      const body = new FormData();
      body.append('roomID', `${id}`);
      body.append('image', this.selectedFile, this.selectedFile.name);
      body.append('room_name', this.editForm.value.roomName);
      body.append('room_type_id', this.editForm.value.roomTypeID);
      body.append('hotel_id', this.editForm.value.hotelID);

      this.roomService.updateRoom(body).subscribe(data => {
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
