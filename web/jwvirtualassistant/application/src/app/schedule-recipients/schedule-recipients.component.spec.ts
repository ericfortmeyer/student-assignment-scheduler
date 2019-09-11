import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ScheduleRecipientsComponent } from './schedule-recipients.component';

describe('ScheduleRecipientsComponent', () => {
  let component: ScheduleRecipientsComponent;
  let fixture: ComponentFixture<ScheduleRecipientsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ScheduleRecipientsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ScheduleRecipientsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
