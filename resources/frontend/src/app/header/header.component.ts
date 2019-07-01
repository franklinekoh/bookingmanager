import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor() { }

  heading = 'Hotels';
  subheading = 'Hotel Admin Manager';
  icon = 'fa fa-hotel';

  ngOnInit() {
  }

}
