import { Injectable, OnInit } from '@angular/core';
import * as firebase from 'firebase';
import { UserInterface } from './news.model';
import { Subject } from 'rxjs';
@Injectable({
  providedIn: 'root',
})
export class DataService implements OnInit {
  labels = [
    '影視娛樂',
    '揪團好康',
    '交通路況',
    '氣候天氣',
    '生活優惠',
    '藝文展覽',
    '比賽活動',
    '幼童親子',
    '寵物友善',
    '社會狀況',
  ];
  userInfo = new Subject<UserInterface>();
  // rangeComeout = new Subject<number>();
  constructor() {
    // firebase.initializeApp(this.config);
    // this.initFirebase();
  }
  ngOnInit() {}
  initFirebase() {
    firebase.initializeApp({
      apiKey: 'AIzaSyDwttsfE1ptoeK7vqtJR2in82foVLcNoW8',
      authDomain: 'forinterview-220600.firebaseapp.com',
      databaseURL: 'https://forinterview-220600.firebaseio.com',
      projectId: 'forinterview-220600',
      storageBucket: 'forinterview-220600.appspot.com',
      messagingSenderId: '1048431628746',
    });
  }
  // updateValue() {
  //   // const db = firebase.firestore();
  //   // db.collection('users')
  //   // 新增內容
  //   //   .add(news)
  //   //   .then(function(docRef) {
  //   //     console.log('Document written with ID: ', docRef.id);
  //   //   })
  //   //   .catch(function(error) {
  //   //     console.error('Error adding document: ', error);
  //   //   });
  //   // 得到內容
  //   // db.collection('users')
  //   //   .get()
  //   //   .then(querySnapshot => {
  //   //     // console.log(querySnapshot.metadata());
  //   //     querySnapshot.forEach(doc => {
  //   //       console.log(`${doc.id} => ${doc.data().classes}`, typeof doc.data().classes);
  //   //     });
  //   //   });
  //   // 單一或多重更新
  //   // const batch = db.batch();
  //   // const ref = db.collection('news').doc(id);
  //   // batch.update(ref, news);
  //   // batch.commit().then(function (response) {
  //   //   console.log(response);
  //   // });
  //   // 直接更新
  //   // db.collection('news').doc(id).update(news).then(
  //   //   (Response) => {console.log(Response);
  //   // });
  //   // 雙向溝通，要是資料存在或不存在，就做什麼事
  //   // const db = firebase.firestore();
  //   // const userRef = db.collection('users').doc('test23@tset.com.tw');
  //   // db.runTransaction(function(transaction) {
  //   //   return transaction.get(userRef).then(function(sfDoc) {
  //   //     if (sfDoc.exists) {
  //   //       throw new Error('Document does not exist!');
  //   //     }
  //   //     transaction.set(userRef, { population: 'newPopulation' });
  //   //     // return newPopulation;
  //   //   });
  //   // })
  //   //   .then(function(newPopulation) {
  //   //     console.log('Population increased to ', newPopulation);
  //   //   })
  //   //   .catch(function(err) {
  //   //     // This will be an "population is too big" error.
  //   //     console.error(err);
  //   //   });
  // }
  // getGeolocation() {
  //   // 給 getCurrentPosition 的回函
  //   // const geoSuccess = function(position: any) {
  //   //   vm.lat = <number>position.coords.latitude;
  //   //   vm.lng = <number>position.coords.longitude;
  //   // };
  //   return new Promise((res, rej) => {
  //     navigator.geolocation.getCurrentPosition(res, rej);
  //   });
  // }
  // GetDistance(lat: number, lng: number, lat2: number, lng2: number) {
  //   const radLat1 = (lat * Math.PI) / 180.0;
  //   const radLat2 = (lat2 * Math.PI) / 180.0;
  //   const a = radLat1 - radLat2;
  //   const b = (lng * Math.PI) / 180.0 - (lng2 * Math.PI) / 180.0;
  //   let s =
  //     2 *
  //     Math.asin(
  //       Math.sqrt(
  //         Math.pow(Math.sin(a / 2), 2) +
  //           Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)
  //       )
  //     );
  //   s = s * 6378.137; // EARTH_RADIUS;
  //   s = Math.round(s * 10000) / 10000;
  //   return s;
  // }
  getNews(toCollection: string) {
    const db = firebase.firestore();
    // // get once 得到一次
    return db.collection(toCollection).get();
    // // listen for realtime updates 隨時監聽
    // const vm = this;
    // const unsubscribe = db.collection('news')
    //   .onSnapshot( function(querySnapshot) {
    //     querySnapshot.forEach(doc => {
    //       const news: News = <News>doc.data();
    //       news.id = doc.id;
    //       if (vm.getNormalNews.length < 5) {
    //         vm.getNormalNews.push(news);
    //       } else if (vm.getTopNews.length < 3) {
    //         vm.getTopNews.push(news);
    //       }
    //     });
    //   }, function(error) {console.error(error); });
    // unsubscribe();
  }
  getUser(email: string) {
    return firebase.firestore().collection('users').doc(email).get();
  }
  getData(col: string, doc: string) {
    return this.fireBase().collection(col).doc(doc).get();
  }
  getDatas(col: string) {
    return this.fireBase().collection(col).get();
  }
  getWhereDatas(col: string, key: string, opt: firebase.firestore.WhereFilterOp, value: any) {
    return this.fireBase().collection(col).where(key, opt, value).get();
  }
  updateData(col: string, doc: string, value: any) {
    return this.fireBase().collection(col).doc(doc).update(value);
  }
  addData(col: string, doc: string, value: any) {
    return this.fireBase().collection(col).doc(doc).set(value);
  }
  fireBase() {
    return firebase.firestore();
  }
}
