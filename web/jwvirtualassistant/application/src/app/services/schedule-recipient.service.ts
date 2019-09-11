import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ScheduleRecipientsPayload } from '../schedule-recipients-payload';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})

export class ScheduleRecipientService {
  private scheduleRecipientsUrl = `${environment.host}:${environment.port}/schedule_recipients`;
  constructor(private http: HttpClient) {}
  getScheduleRecipients = (): Observable<ScheduleRecipientsPayload> => this.http.get<ScheduleRecipientsPayload>(this.scheduleRecipientsUrl);
}
