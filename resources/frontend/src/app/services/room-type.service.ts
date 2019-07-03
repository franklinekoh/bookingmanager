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
}
