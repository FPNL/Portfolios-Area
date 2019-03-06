import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from 'src/app/shared/auth.service';
import { DataService } from 'src/app/shared/data.service';

@Injectable({
  providedIn: 'root',
})
export class AuthGuardService implements CanActivate {
  constructor(
    private authService: AuthService,
    private router: Router,
    private dataService: DataService
  ) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean | Observable<boolean> | Promise<boolean> {
    const articleId = route.paramMap.get('id');
    const loginAccount = this.authService.account;
    return this.dataService.getData('news', articleId).then(doc => {
      if (loginAccount === doc.data().user.account) {
        return true;
      } else {
        this.router.navigate(['/']);
        return false;
      }
    });
  }
}
