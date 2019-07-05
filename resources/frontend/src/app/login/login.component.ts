import {Component, OnDestroy, OnInit} from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { Router } from '@angular/router';
import { AuthService} from '../services/auth.service';
import {Location} from '@angular/common';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit, OnDestroy {
  loginForm: any;
  constructor(private formBuilder: FormBuilder,
              private toastr: ToastrService,
              private router: Router,
              private location: Location,
              private authService: AuthService) {
    this.loginForm = this.formBuilder.group({
      'email': ['', [Validators.required, Validators.email]],
      'password': ['', Validators.required]
    });
  }

  ngOnInit(): void {
    document.body.classList.add('text-left');
  }
  ngOnDestroy(): void {
    document.body.classList.remove('text-left');
  }

  submitLogin() {
    if (this.loginForm.dirty && this.loginForm.valid) {
      this.toastr.info('please wait...', 'Authenticating');
      this.authService.login({
        'email': this.loginForm.value.email,
        'password': this.loginForm.value.password
      }).subscribe((data) => {
            this.router.navigate(['hotel']);
      }, error => {
        if (error.status === 401) {
          this.toastr.error('Login failed, try again');

        }
      });
    }
  }
}
