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
    $(document).ready(function(){var e=$(".menu-toggle"),a=$(".sidebar-left"),
      n=$(".sidebar-left-secondary"),i=$(".sidebar-overlay"),t=$(".main-content-wrap"),
      s=$(".nav-item");function o(){a.addClass("open"),t.addClass("sidenav-open")}function l(){a.removeClass("open"),
      t.removeClass("sidenav-open")}function d(){n.addClass("open"),i.addClass("open")}function c(){n.removeClass("open"),
      i.removeClass("open")}$(window).on("resize",function(e){gullUtils.isMobile()&&(l(),c())}),
      s.each(function(e){var a=$(this);if(a.hasClass("active")){var i=a.data("item");n.find('[data-parent="'+i+'"]').show()}})
      ,gullUtils.isMobile()&&(l(),c()),a.find(".nav-item").on("mouseenter",function(e){var a,i=$(e.currentTarget),
      t=i.data("item");t?(a=i,$(".nav-item").removeClass("active"),a.addClass("active"),d()):c(),n.find(".childNav").hide(),
      n.find('[data-parent="'+t+'"]').show()}),
      a.find(".nav-item").on("click",function(e){$(event.currentTarget).data("item")&&e.preventDefault()}),
      i.on("click",function(e){gullUtils.isMobile()&&l(),c()}),e.on("click",function(e){var i=a.hasClass("open"),
      t=n.hasClass("open"),s=$(".nav-item.active").data("item");i&&t&&gullUtils.isMobile()?(l(),
      c()):i&&t?c():i?l():i||t||s?i||t||(o(),d()):o()})});
  }
  logOut() {
    this.authService.logout();
    this.router.navigate(['login']);
  }

  getUserName() {
    return JSON.parse(localStorage.getItem('currentUser')).fullname;
  }


}
