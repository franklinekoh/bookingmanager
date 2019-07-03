import { Component, OnInit } from '@angular/core';
import {ToastrService} from 'ngx-toastr';
import {ActivatedRoute, Router} from '@angular/router';
import { Location } from '@angular/common';
import { PriceService } from '../../services/price.service';

@Component({
  selector: 'app-view-price',
  templateUrl: './view-price.component.html',
  styleUrls: ['./view-price.component.css']
})
export class ViewPriceComponent implements OnInit {

  constructor(
    private route: ActivatedRoute,
    private location: Location,
    private toastr: ToastrService,
    private router: Router,
    private price: PriceService) { }
  priceData: any;
  heading = 'Price Detail'
  ngOnInit() {
    this.getPrice();
  }
  goBack(): void {
    this.location.back();
  }
  getPrice() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.price.getPriceByID(id).subscribe(data => {
      this.priceData = data.data;
      console.log(data.data);
    }, error => {
      console.log(error);
    });
  }
}
