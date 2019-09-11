import { Component, OnInit } from '@angular/core';
import { ScheduleRecipient } from '../schedule-recipient';
import { Observable } from 'rxjs';
import { ScheduleRecipientService } from '../services/schedule-recipient.service';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-schedule-recipients',
  styleUrls: ['./schedule-recipients.component.css'],
  templateUrl: 'schedule-recipients.component.html'
})

export class ScheduleRecipientsComponent implements OnInit {
  scheduleRecipientsObs$: Observable<ScheduleRecipient[]>;
  constructor(private scheduleRecipientsService: ScheduleRecipientService) { }
  ngOnInit() {
    this.scheduleRecipientsObs$ = this.scheduleRecipientsService.getScheduleRecipients().pipe(
      map(payload => payload._embedded.scheduleRecipients.map(recipient => recipient))
    );
  }
}
