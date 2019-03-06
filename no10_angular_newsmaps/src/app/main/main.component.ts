import { Component, OnInit } from '@angular/core';
import { News } from '../shared/news.model';
import { DataService } from '../shared/data.service';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.sass'],
})
export class MainComponent implements OnInit {
  // @Output() turnToMain = new EventEmitter();
  topColumn = [1, 2, 3];
  normalColumn = ['a', 'b', 'c', 'd', 'e'];
  getNormalNews: News[] = [];
  getTopNews: News[] = [];
  getFrom = 'news';
  constructor(private dataService: DataService) {}

  ngOnInit() {
    this.getMultiNews();
  }
  getMultiNews() {
    this.dataService.getNews(this.getFrom)
    .then(querySnapshot => {
      // console.log(querySnapshot.metadata());
      querySnapshot.forEach(doc => {
        const news: News = <News>doc.data();
        news.id = doc.id;
        if (this.getNormalNews.length < 5) {
          this.getNormalNews.push(news);
        } else if (this.getTopNews.length < 3) {
          this.getTopNews.push(news);
        }
      });
    });
  }
}
