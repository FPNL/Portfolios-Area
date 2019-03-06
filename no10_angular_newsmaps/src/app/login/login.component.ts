import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../shared/auth.service';
import { trigger, style, state, transition, animate } from '@angular/animations';
import { Subscription } from 'rxjs';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass'],
  animations: [
    trigger('loginState', [
      state(
        'login',
        style({
          display: 'block',
        })
      ),
      state(
        'signup',
        style({
          display: 'none',
        })
      ),
      state(
        'success',
        style({
          display: 'none',
        })
      ),
      transition('normal <=> highlited', animate(500)),
    ]),
    trigger('signupState', [
      state(
        'login',
        style({
          display: 'none',
        })
      ),
      state(
        'signup',
        style({
          display: 'block',
        })
      ),
      state(
        'success',
        style({
          display: 'none',
        })
      ),
      transition('normal <=> highlited', animate(500)),
    ]),
    trigger('successState', [
      state(
        'success',
        style({
          display: 'block',
        })
      ),
      transition('* => highlited', animate(500)),
    ]),
  ],
})
export class LoginComponent implements OnInit {
  state = 'login';
  login: FormGroup;
  loginError = false;
  basicInfo: { account: string; password: string };
  subscription: Subscription;
  // basicInfo = {account: '', password: ''};
  constructor(
    private router: Router,
    private form: FormBuilder,
    private authService: AuthService,
  ) {}

  ngOnInit() {
    this.login = this.form.group({
      account: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.minLength(6), Validators.required]],
    });
  }
  onSubmit() {
    const account = this.login.value.account;
    const password = this.login.value.password;
    if (this.login.valid) {
      this.authService.signinUser(account, password)
      .catch( err => {
        this.loginError = true;
        setTimeout(() => {
          this.loginError = false;
        }, 5000);
      });
    }
  }
  goSignup() {
    const account = this.login.value.account;
    const password = this.login.value.password;
    this.basicInfo = { account: account, password: password };
    if (this.login.valid) {
      this.state = 'signup';
    }
  }
}
