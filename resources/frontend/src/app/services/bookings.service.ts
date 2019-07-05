import { Injectable } from '@angular/core';

import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BookingsService {

  constructor(private http: HttpClient) { }

  getAllBooking() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.get(environment.apiUrl + 'bookings', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getFilteredBooking(year: number, month: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.get(environment.apiUrl + `bookings/filter?year=${year}&month=${month}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getBooking(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.get(`${environment.apiUrl}bookings/${id}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getTotalValueForBooking(body: any) {

    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.post(`${environment.apiUrl}bookings/total`, body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  updateBooking(body: any) {

    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.put(`${environment.apiUrl}bookings`, body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {
        return throwError(err);
      })
    );
  }

  createBooking(body: any) {

    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.post(`${environment.apiUrl}bookings/user`, body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {
        return throwError(err);
      })
    );
  }

  deleteBooking(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json',
        'Authorization': localStorage.getItem('authToken')
      })
    };

    return this.http.delete(`${environment.apiUrl}bookings/${id}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
}
