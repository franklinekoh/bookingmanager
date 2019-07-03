import { Injectable } from '@angular/core';

import { environment} from '../../environments/environment';
import { HttpClient, HttpHeaders,  } from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of, throwError} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PriceService {

  constructor(private http: HttpClient) { }
  getAllPrices() {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + 'price', httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }

  createPrice(body: any) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.post(environment.apiUrl + 'price', body, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  getPriceByID(priceID: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.get(environment.apiUrl + `price/${priceID}`, httpOptions).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
  deletePrice(priceID: number) {
    const httpOptions: any = {
      headers: new HttpHeaders({
        'content-type': 'application/json'
      })
    };

    return this.http.delete(environment.apiUrl + `price/${priceID}`).pipe(
      tap((data: any) => {
      }),
      catchError(err => {

        return throwError(err);
      })
    );
  }
}
