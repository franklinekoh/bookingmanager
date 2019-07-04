import { Component, OnInit } from '@angular/core';
import { RoomTypeService } from '../../services/room-type.service';
import {ToastrService} from 'ngx-toastr';
import {Router} from '@angular/router';

@Component({
  selector: 'app-room-types',
  templateUrl: './room-types.component.html',
  styleUrls: ['./room-types.component.css']
})
export class RoomTypesComponent implements OnInit {

  constructor(private roomTypeService: RoomTypeService,
              private router: Router,
              private toastr: ToastrService) { }
  heading = 'Room types';
  roomTypeData: any[];
  ngOnInit() {
    this.getRoomTypes();
  }

  getRoomTypes() {
    this.roomTypeService.getRoomTypes().subscribe(data => {
      this.roomTypeData = data.data;
    }, error => {
      console.log(error);
    });
  }

  deleteRoomType(id: number) {
      this.roomTypeService.deleteRoomType(id).subscribe( data => {
        if (data.status) {
          this.router.navigateByUrl('/', {skipLocationChange: true}).then(() =>
            this.router.navigate(['price']));
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
