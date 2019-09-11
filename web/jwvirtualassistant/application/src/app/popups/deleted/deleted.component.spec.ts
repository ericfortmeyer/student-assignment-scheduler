import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DeletedPopupComponent } from './deleted.component';

describe('DeletedPopupComponent', () => {
  let component: DeletedPopupComponent;
  let fixture: ComponentFixture<DeletedPopupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DeletedPopupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DeletedPopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
