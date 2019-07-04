import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewRoomTypeComponent } from './view-room-type.component';

describe('ViewRoomTypeComponent', () => {
  let component: ViewRoomTypeComponent;
  let fixture: ComponentFixture<ViewRoomTypeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ViewRoomTypeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ViewRoomTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
