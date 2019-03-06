import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { LoginRoutingModule } from './login-routing.module';
import { LoginComponent } from './login.component';
import { SignupComponent } from './signup/signup.component';
import { SignupSuccessComponent } from './signup-success/signup-success.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ShareMatModule } from '../shared/shareMat.module';

@NgModule({
  declarations: [
    LoginComponent,
    SignupComponent,
    SignupSuccessComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ShareMatModule,
    LoginRoutingModule
  ]
})
export class LoginModule { }
