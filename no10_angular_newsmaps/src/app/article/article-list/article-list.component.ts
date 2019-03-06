import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { News } from 'src/app/shared/news.model';
import { DataService } from 'src/app/shared/data.service';

@Component({
  selector: 'app-article-list',
  templateUrl: './article-list.component.html',
  styleUrls: ['./article-list.component.sass']
})
export class ArticleListComponent implements OnInit {
  news: News[];
  noNews = false;
  value: string;
  constructor(private activatedRouter: ActivatedRoute, private dataService: DataService) { }

  ngOnInit() {
    let key: string;
    this.activatedRouter.queryParamMap.subscribe(
      (query: any) => {
        this.noNews = false;
      let opt: any;
      key = query.params['key'];
      this.value = query.params['value'];
        if (key === 'author') {
          key = 'user.nickname';
          this.value = this.value[0].toUpperCase() + this.value.slice(1);
        } else if (key === 'labels') {
          opt = 'array-contains';
        }
      this.search(key, this.value, opt);
    });

  }
  search(key: string, value: string, opt: any = '>=') {
    this.dataService.getWhereDatas('news', key, opt, value)
    .then((docQuery) => {
      this.news = [];
      if (docQuery.size > 0) {
        docQuery.forEach((doc) => {
          const news = <News>doc.data();
          news.id = doc.id;
          this.news.push(news);
        });
      } else {
        this.noNews = true;
      }
    });
  }

}
