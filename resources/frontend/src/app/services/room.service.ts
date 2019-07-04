import { Injectable } from '@angular/core';

import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RoomService {

  constructor(private http: HttpClient) { }

  getRooms() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + 'room', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getAvailableRooms() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + 'room/get/available', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  createRoom(body: any) {
    return this.http.post(environment.apiUrl + 'room', body).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  updateRoom(body: any) {
      return this.http.post(environment.apiUrl + 'room/edit', body).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getRoomByID(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + `room/${id}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  deleteRoom(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.delete(environment.apiUrl + `room/${id}`).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
}
