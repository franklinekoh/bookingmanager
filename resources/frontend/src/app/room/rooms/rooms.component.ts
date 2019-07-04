import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {ToastrService} from 'ngx-toastr';
import {RoomService} from '../../services/room.service';

@Component({
  selector: 'app-rooms',
  templateUrl: './rooms.component.html',
  styleUrls: ['./rooms.component.css']
})
export class RoomsComponent implements OnInit {

  constructor(private router: Router,
              private toastr: ToastrService,
              private roomService: RoomService
              ) { }

  heading = 'Rooms';
  roomData: any[];
  ngOnInit() {
    this.getRooms();
  }

  getRooms() {
    this.roomService.getRooms().subscribe(data => {
      this.roomData = data.data;
    }, error => {
      console.log(error);
    });
  }
}
