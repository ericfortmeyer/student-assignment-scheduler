import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UpdatedPopupComponent } from './updated.component';

describe('UpdatedPopupComponent', () => {
  let component: UpdatedPopupComponent;
  let fixture: ComponentFixture<UpdatedPopupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UpdatedPopupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UpdatedPopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
