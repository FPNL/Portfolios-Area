import { Component, OnInit, Input, OnChanges, Output, EventEmitter } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from 'src/app/shared/auth.service';
import { UserInterface } from 'src/app/shared/news.model';
import { DataService } from 'src/app/shared/data.service';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.sass'],
})
export class SignupComponent implements OnInit, OnChanges {
  @Input() basicInfo: { account: ''; password: '' };
  @Output() changeStateToLogin = new EventEmitter();
  @Output() changeStateToSuccess = new EventEmitter();
  signup: FormGroup;
  randomAvatar = [
    'https://bit.ly/2tuoarP',
    'https://bit.ly/2X4rjvF',
    'https://bit.ly/2SW71pj',
    'https://bit.ly/2SQmrv0',
    'https://bit.ly/2S4gUfO',
  ];
  constructor(
    private form: FormBuilder,
    private authService: AuthService,
    private dataService: DataService
  ) {}

  ngOnInit() {
    this.signup = this.form.group({
      account: [null, [Validators.required, Validators.email]],
      password: [null, [Validators.minLength(6), Validators.required]],
      lastname: [null, Validators.required],
      firstname: [null, Validators.required],
      nickname: [null, Validators.required],
    });
  }
  ngOnChanges() {
    if (this.basicInfo) {
      this.signup.patchValue({
        account: this.basicInfo.account,
        password: this.basicInfo.password,
      });
    }
  }
  onSinup() {
    const account = this.signup.value.account;
    const password = this.signup.value.password;
    if (this.signup.valid) {
      this.authService
        .signupUser(account, password)
        .then(response => {
          this.changeStateToSuccess.emit();
          this.makeUserData();
        })
        .catch(error => {
          console.error(error);
          this.signup.get('account').setErrors({ existed: true });
        });
    }
  }
  makeUserData() {
    const vm = this;
    const signupValue: UserInterface = { ...this.signup.value };
    delete signupValue.password;
    signupValue.avatarPath = this.randomAvatar[Math.floor(Math.random() * 5)];
    signupValue.articles = [];
    this.dataService.getData('users', this.signup.value.account).then(sfDoc => {
      if (sfDoc.exists) {
        throw new Error('Document does not exist!');
      }
      this.dataService.addData('users', this.signup.value.account, signupValue);
      this.dataService.userInfo.next(signupValue);
      return signupValue;
    });
  }
  toPrevious() {
    this.changeStateToLogin.emit();
  }
}
