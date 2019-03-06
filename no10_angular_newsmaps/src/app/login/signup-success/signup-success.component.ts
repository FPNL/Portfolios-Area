import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-signup-success',
  templateUrl: './signup-success.component.html',
  styleUrls: ['./signup-success.component.sass']
})
export class SignupSuccessComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {
  }
  redirectTo() {
    this.router.navigate(['/']);
  }
}
