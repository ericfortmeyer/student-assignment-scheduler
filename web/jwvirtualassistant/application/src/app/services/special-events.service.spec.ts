import { TestBed } from '@angular/core/testing';

import { SpecialEventsService } from './special-events.service';

describe('SpecialEventsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: SpecialEventsService = TestBed.get(SpecialEventsService);
    expect(service).toBeTruthy();
  });
});
