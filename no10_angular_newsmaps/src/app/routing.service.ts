import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RoutingService {
  login = false;
  loginSub = new Subject<boolean>();

  constructor() { }
  changeRoutingStatus(logginOrNot: boolean) {
    this.login = logginOrNot;
    this.loginSub.next(logginOrNot);
  }
}
