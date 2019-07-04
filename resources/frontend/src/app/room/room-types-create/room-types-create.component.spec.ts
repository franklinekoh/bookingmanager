import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RoomTypesCreateComponent } from './room-types-create.component';

describe('RoomTypesCreateComponent', () => {
  let component: RoomTypesCreateComponent;
  let fixture: ComponentFixture<RoomTypesCreateComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RoomTypesCreateComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RoomTypesCreateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
