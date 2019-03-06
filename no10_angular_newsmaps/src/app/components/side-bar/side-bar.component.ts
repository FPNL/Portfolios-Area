import { Component, OnInit } from '@angular/core';
import { DataService } from 'src/app/shared/data.service';
import * as firebase from 'firebase';
import { News } from 'src/app/shared/news.model';
import { Router } from '@angular/router';
@Component({
  selector: 'app-side-bar',
  templateUrl: './side-bar.component.html',
  styleUrls: ['./side-bar.component.sass']
})
export class SideBarComponent implements OnInit {
  labels: string[];
  news: News[];
  constructor(private dataService: DataService, private router: Router) { }

  ngOnInit() {
    this.labels = this.dataService.labels;

    firebase.firestore().collection('news').orderBy('info.readers').limit(5).get().then(
      queryDoc => {
        this.news = [];
        queryDoc.forEach(doc => {
          const news = <News>doc.data();
          news.id = doc.id;
          this.news.push(news);
        });
      }
    );
  }
  goToSearch(label) {
    this.router.navigate(['/article', 'search'], {queryParams: {key: 'labels', value: label}});

  }

}
