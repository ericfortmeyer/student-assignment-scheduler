import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CenteredSpinnerComponent } from './centered-spinner.component';

describe('CenteredSpinnerComponent', () => {
  let component: CenteredSpinnerComponent;
  let fixture: ComponentFixture<CenteredSpinnerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CenteredSpinnerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CenteredSpinnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
