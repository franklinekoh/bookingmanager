import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import { RoomService } from '../../services/room.service';


@Component({
  selector: 'app-view-room',
  templateUrl: './view-room.component.html',
  styleUrls: ['./view-room.component.css']
})
export class ViewRoomComponent implements OnInit {

  constructor(private roomService: RoomService,
              private route: ActivatedRoute,
              private location: Location) { }
  heading = 'Room Details';
  roomData: any;
  ngOnInit() {
    this.getRoom();
  }

  getRoom() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.roomService.getRoomByID(id).subscribe(data => {
      this.roomData = data.data;
    }, err => {
      console.log(err);
    });
  }

}
