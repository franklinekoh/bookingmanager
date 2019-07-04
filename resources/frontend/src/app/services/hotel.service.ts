import { Injectable } from '@angular/core';

import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HotelService {

  constructor(private http: HttpClient) { }
  getAllHotel() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + 'hotel', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  getHotel(id: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(`${environment.apiUrl}hotel/${id}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  editHotel(body: any) {
    return this.http.post(`${environment.apiUrl}hotel`, body).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
}
