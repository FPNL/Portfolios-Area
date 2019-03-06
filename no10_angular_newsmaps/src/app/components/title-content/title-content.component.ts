import { Component, OnInit, Input } from '@angular/core';
import { News } from 'src/app/shared/news.model';
import { Subscription } from 'rxjs';
import { Router } from '@angular/router';

@Component({
  selector: 'app-title-content',
  templateUrl: './title-content.component.html',
  styleUrls: ['./title-content.component.sass'],
})
export class TitleContentComponent implements OnInit {
  @Input() inputNewsContent: News;
  range: number;
  subscription: Subscription;
  constructor(private router: Router) {}

  ngOnInit() {
    // this.getRange();
  }
  // getRange() {
  //   // 經緯度經由 input 傳入
  //   const lat = this.inputNewsContent.info.location.latitude;
  //   const lng = this.inputNewsContent.info.location.longitude;
  //   const vm = this;
  //   const fn = function(position: any) {
  //     const lat2 = <number>position.coords.latitude;
  //     const lng2 = <number>position.coords.longitude;
  //     // vm.range = vm.dataService.GetDistance(lat, lng, lat2, lng2);
  //   };
  //   // 判斷 是否有給權限，並且持續追蹤
  //   // navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
  //   //   if (result.state === 'granted') {
  //   //     console.log('yy', result.state);
  //   //   } else if (result.state === 'prompt') {
  //   //     console.log('xx', result.state);
  //   //     vm.dataService
  //   //       .getGeolocation()
  //   //       .then(fn)
  //   //       .catch(err => {
  //   //         console.error(err);
  //   //       });
  //   //   } else if (result.state === 'denied') {
  //   //     console.log(result.state);
  //   //   }
  //   //   result.onchange = function() {
  //   //     console.log(result.state);
  //   //     vm.dataService
  //   //       .getGeolocation()
  //   //       .then(fn)
  //   //       .catch(err => {
  //   //         console.error(err);
  //   //       });
  //   //   };
  //   // });
  // }
  goToSearch(label)  {
    this.router.navigate(['/article', 'search'], {queryParams: {key: 'labels', value: label}});
  }
}
