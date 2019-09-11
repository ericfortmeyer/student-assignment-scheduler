import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { SpecialEventsService } from '../services/special-events.service';
import { SpecialEvent } from '../special-event';

@Component({
  selector: 'app-special-events',
  styleUrls: ['./special-events.component.css'],
  templateUrl: './special-events.component.html'
})

export class SpecialEventsComponent implements OnInit {
  specialEventsObs$: Observable<SpecialEvent[]>;
  constructor(private specialEventsService: SpecialEventsService) { }
  ngOnInit() {
    this.specialEventsObs$ = this.specialEventsService.getSpecialEvents().pipe(
      map(payload => payload._embedded.specialEvents.map(ev => ev))
    );
  }
}
