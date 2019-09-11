import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatedPopupComponent } from './created.component';

describe('CreatedPopupComponent', () => {
  let component: CreatedPopupComponent;
  let fixture: ComponentFixture<CreatedPopupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreatedPopupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreatedPopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
