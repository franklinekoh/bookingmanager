import { Component, OnInit } from '@angular/core';
import { PriceService} from '../../services/price.service';
import {ActivatedRoute, Router} from '@angular/router';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-prices',
  templateUrl: './prices.component.html',
  styleUrls: ['./prices.component.css']
})
export class PricesComponent implements OnInit {

  constructor(private priceService: PriceService,
              private router: Router,
              private toastr: ToastrService) { }

  heading = 'Prices';
  priceData: any[];
  ngOnInit() {
    this.getAllPrices();
  }

  getAllPrices() {
    this.priceService.getAllPrices().subscribe(data => {
      this.priceData = data.data;
      console.log(data);
    }, error => {
      console.log(error);
    });
  }

  deletePrice(priceID) {
    this.priceService.deletePrice(priceID).subscribe(data => {

      if (data.status === true){
        this.router.navigateByUrl('/', {skipLocationChange: true}).then(() =>
          this.router.navigate(['price']));
        this.toastr.success(data.message);
      } else {
        this.toastr.error(data.message);
      }
    }, error => {
      console.log(error);
    });
  }

}
