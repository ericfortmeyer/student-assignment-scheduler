import { TestBed } from '@angular/core/testing';

import { AuthorizationTokenService } from './authorization-token.service';

describe('AuthorizationTokenService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AuthorizationTokenService = TestBed.get(AuthorizationTokenService);
    expect(service).toBeTruthy();
  });
});
