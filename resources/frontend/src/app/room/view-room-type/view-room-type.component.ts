import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import { Location } from '@angular/common';
import { RoomTypeService} from '../../services/room-type.service';

@Component({
  selector: 'app-view-room-type',
  templateUrl: './view-room-type.component.html',
  styleUrls: ['./view-room-type.component.css']
})
export class ViewRoomTypeComponent implements OnInit {

  constructor( private route: ActivatedRoute,
               private location: Location,
               private roomType: RoomTypeService) { }
  roomTypeData: any;
  heading = 'View Room Type';
  ngOnInit() {
    this.getRoomType();
  }

  goBack(): void {
    this.location.back();
  }
  getRoomType() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.roomType.getRoomTypeByID(id).subscribe(data => {
      this.roomTypeData = data.data;
    }, error => {
      console.log(error);
    });
  }
}
