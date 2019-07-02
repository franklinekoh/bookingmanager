import { Component, OnInit } from '@angular/core';
import { AuthService} from '../services/auth.service';
import { Router} from '@angular/router';
declare var $: any;

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor(private authService: AuthService,
              private router: Router,
              ) { }

  heading = 'Hotels';
  subheading = 'Hotel Admin Manager';
  icon = 'fa fa-hotel';

  ngOnInit() {

  }
  logOut() {
    this.authService.logout();
    this.router.navigate(['login']);
  }


}
