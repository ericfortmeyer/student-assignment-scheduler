import { TestBed } from '@angular/core/testing';

import { ScheduleRecipientService } from './schedule-recipient.service';

describe('ScheduleRecipientService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ScheduleRecipientService = TestBed.get(ScheduleRecipientService);
    expect(service).toBeTruthy();
  });
});
