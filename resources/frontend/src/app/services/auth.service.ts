import { Injectable } from '@angular/core';
import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';
import { ApiResponse} from '../types/api-response';
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
          const access_token: string = 'Bearer ' + data.access_token;
          this.getUser(access_token).subscribe((data: any) => {
            console.log(data);
            localStorage.setItem('currentUser', JSON.stringify(data.data));

          });
        }
      return data;
      }),
      catchError(err => {

        return throwError(err);
      })
    );
}

  logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('currentUser');
    localStorage.removeItem('authToken');
  }

  isLoggedIn() {
    return JSON.parse(localStorage.getItem('currentUser') || 'false');
  }

  getUser(authToken: string): Observable<ArrayBuffer> {

    const httpOptions: any = {
      headers: new HttpHeaders({
        'Authorization': authToken
      })
    }

    return this.http.get(environment.apiUrl + 'auth/user', httpOptions).pipe(
      tap((data) => {
          return data;
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  public isAuthenticated(): boolean {

    const authToken = localStorage.getItem('authToken');

    return !this.jwtHelper.isTokenExpired(authToken);
  }
}
