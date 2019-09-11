import { TestBed, ComponentFixture, async } from '@angular/core/testing';

import { ContactService } from './contact.service';
import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';

describe('ContactService', () => {
  let service: ContactService;
  let httpMock: HttpTestingController;
  let fixture: ComponentFixture<ContactService>;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ContactService],
      providers: [ContactService],
      imports: [
        HttpClientTestingModule
      ]
    })
    .compileComponents();
  }));
  beforeEach(() => {
    fixture = TestBed.createComponent(ContactService);
    httpMock = TestBed.get(HttpClientTestingModule);
    service = fixture.componentInstance;
    fixture.detectChanges();
  })

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
