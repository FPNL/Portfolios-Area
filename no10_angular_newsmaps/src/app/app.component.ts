import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router, Event, NavigationStart } from '@angular/router';
import { FormBuilder, FormGroup } from '@angular/forms';
import { DataService } from './shared/data.service';
import { UserInterface } from './shared/news.model';
import { Subscription } from 'rxjs';
import { AuthService } from './shared/auth.service';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass'],
})
export class AppComponent implements OnInit, OnDestroy {
  login = false;
  searchGroup: FormGroup;
  user: UserInterface;
  subscription: Subscription;
  searchClass = [
    { title: '作者', content: 'author' },
    { title: '文章', content: 'title' },
    { title: '標籤', content: 'labels' },
  ];
  constructor(
    private dataService: DataService,
    private authService: AuthService,
    private router: Router,
    private formbuilder: FormBuilder
  ) {}
  ngOnInit() {
    this.dataService.initFirebase();
    this.searchGroup = this.formbuilder.group({
      searchQuery: '',
      searchClass: 'author',
    });
    this.router.events.subscribe((event: Event) => {
      if (event instanceof NavigationStart) {
        if (event.url === '/login') {
          this.login = true;
        } else {
          this.login = false;
        }
      }
    });
    this.subscription = this.dataService.userInfo.subscribe((user: UserInterface) => {
      this.user = user;
    });
  }
  toLogin() {
    this.router.navigate(['/login']);
  }
  toLogout() {
    this.authService.logout();
    this.user = null;
  }
  search() {
    const key = this.searchGroup.get('searchClass').value;
    const value = this.searchGroup.get('searchQuery').value;
    this.router.navigate(['article', 'search'], { queryParams: { key: key, value: value } });
  }
  ngOnDestroy() {
    this.subscription.unsubscribe();
  }
}
