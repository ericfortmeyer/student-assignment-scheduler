import { TestBed } from '@angular/core/testing';

import { TemplatesForIncompleteMonthsOfAssignmentsService } from './templates-for-incomplete-months-of-assignments.service';

describe('TemplatesForIncompleteMonthsOfAssignmentsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: TemplatesForIncompleteMonthsOfAssignmentsService = TestBed.get(TemplatesForIncompleteMonthsOfAssignmentsService);
    expect(service).toBeTruthy();
  });
});
