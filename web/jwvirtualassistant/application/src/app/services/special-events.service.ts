import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { SpecialEventsPayload } from '../special-events-payload';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})

export class SpecialEventsService {
  private specialEventsUrl = `${environment.host}:${environment.port}/special_events`;
  constructor(private http: HttpClient) { }
  getSpecialEvents = (): Observable<SpecialEventsPayload> => this.http.get<SpecialEventsPayload>(this.specialEventsUrl);
}
