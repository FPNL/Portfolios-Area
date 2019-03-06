import * as firebase from 'firebase';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { DataService } from './data.service';
import { UserInterface } from './news.model';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  token: string;
  account: string;
  constructor(private router: Router, private dataService: DataService) {}

  signupUser(email: string, password: string) {
    this.account = email;
    return firebase.auth().createUserWithEmailAndPassword(email, password);
  }

  signinUser(email: string, password: string) {
    this.account = email;
    return firebase
      .auth()
      .signInWithEmailAndPassword(email, password)
      .then(response => {
        this.router.navigate(['/']);
        firebase
          .auth()
          .currentUser.getIdToken()
          .then((token: string) => {
            this.token = token;
          });
        firebase
          .firestore()
          .collection('users')
          .doc(email)
          .get()
          .then(doc => {
            this.dataService.userInfo.next(<UserInterface>doc.data());
          });
      });
  }

  logout() {
    firebase.auth().signOut();
    this.token = null;
  }

  // getToken() {
  //   firebase
  //     .auth()
  //     .currentUser.getIdToken()
  //     .then((token: string) => {
  //       this.token = token;
  //     });
  //   return this.token;
  // }

  isAuthenticated() {
    return this.token != null;
  }
}
