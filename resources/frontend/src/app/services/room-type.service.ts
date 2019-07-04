import { Injectable } from '@angular/core';

import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RoomTypeService {

  constructor(private http: HttpClient) { }

  getRoomTypes() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + 'room/type', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  createRoomTypes(body: any) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.post(environment.apiUrl + 'room/type', body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  updateRoomTypes(body: any) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.put(environment.apiUrl + 'room/type', body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  getRoomTypeByID(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + `room/type/${id}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  deleteRoomType(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.delete(environment.apiUrl + `room/type/${id}`).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
}
