import { Injectable } from '@angular/core';
import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';
import {JwtHelperService} from '@auth0/angular-jwt';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http: HttpClient,
              public jwtHelper: JwtHelperService) { }
  login(body: any) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.post(environment.apiUrl + 'auth/login', body, httpOptions).pipe(
      tap((data: any) => {

        if (data.access_token) {
          localStorage.setItem('authToken', data.access_token);
          localStorage.setItem('currentUser', JSON.stringify(data.user));
        }
      return data;
      }),
      catchError(err => {

        return throwError(err);
      })
    );
}

  logout() {
    localStorage.removeItem('currentUser');
    localStorage.removeItem('authToken');
  }

  public isAuthenticated(): boolean {

    const authToken = localStorage.getItem('authToken');

    return !this.jwtHelper.isTokenExpired(authToken);
  }
}
