import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { News, InfoInterface } from 'src/app/shared/news.model';
import { DataService } from 'src/app/shared/data.service';
import { AuthService } from 'src/app/shared/auth.service';

@Component({
  selector: 'app-article-content',
  templateUrl: './article-content.component.html',
  styleUrls: ['./article-content.component.sass'],
})
export class ArticleContentComponent implements OnInit {
  articleId: string;
  getFrom = 'news';
  getNews: News;
  range: number;
  avatar: string;
  alterAuthenticated = false;
  userLogin = false;
  banRating = false;
  successRating = false;
  likeStar = [];
  dislikeStar = [1, 2, 3, 4, 5];
  star = 0;
  info: any;
  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private dataService: DataService,
    private authService: AuthService
  ) {}

  ngOnInit() {
    this.activatedRoute.paramMap.subscribe((paramsMap: any) => {
      this.articleId = paramsMap.params.id;
      this.getContent();
    });
    this.userLogin = this.authService.isAuthenticated();
  }
  navigateToAlter() {
    this.router.navigate(['article', 'alter', this.articleId]);
  }
  getContent() {
    this.dataService
      .getData(this.getFrom, this.articleId)
      .then(sfDoc => {
        if (!sfDoc.exists) {
          throw new Error('Document does not exist!');
        }
        this.getNews = <News>sfDoc.data();
        this.alterAuthenticated =
          this.authService.isAuthenticated() &&
          this.authService.account === this.getNews.user.account;
        setTimeout(() => {
          document
            .getElementById('subtitleGroup')
            .firstElementChild.setAttribute(
              'style',
              'width: 100%;display: flex; justify-content: space-between; align-items: flex-end;'
            );
        }, 100);
        let newReaders = sfDoc.data().info.readers;
        newReaders = newReaders + 1;
        const infos: InfoInterface = <InfoInterface>sfDoc.data().info;
        infos.readers = newReaders;
        this.dataService.updateData(this.getFrom, this.articleId, { info: infos });
        this.info = infos;
        return infos;
      })
      .then(newPopulation => {
        this.dataService
          .getWhereDatas('users', 'account', '==', this.getNews.user.account)
          .then(doc => {
            if (doc.size === 1) {
              doc.forEach(query => {
                this.avatar = query.data().avatarPath;
              });
            }
          });
      });
  }
  goToSearch(label: string) {
    this.router.navigate(['/article', 'search'], { queryParams: { key: 'labels', value: label } });
  }
  passStar(index) {
    this.star = index + 1;
  }
  rateStar() {
    const info = this.info;
    const account = this.authService.account;
    const oldPoint = info.star.point;
    const oldLength = info.star.reviewer.length;
    const nowStar = this.star;
    const haveAlready: boolean = info.star.reviewer.some((item: string) => item === account);
    if (haveAlready) {
      this.banRating = true;
      return;
    } else {
      info.star.reviewer.push(account);
    }
    const newLength = info.star.reviewer.length;
    const newPoint = (oldPoint * oldLength + nowStar) / newLength;
    info.star.point = newPoint.toFixed(1);
    this.dataService
      .updateData('news', this.articleId, { info: info })
      .then(response => (this.successRating = true));
  }
}
