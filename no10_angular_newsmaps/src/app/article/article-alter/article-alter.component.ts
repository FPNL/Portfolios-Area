import { Component, OnInit } from '@angular/core';
import { DataService } from 'src/app/shared/data.service';
import { FormBuilder, FormGroup } from '@angular/forms';
import { ENTER, COMMA } from '@angular/cdk/keycodes';
import { MatChipInputEvent } from '@angular/material/chips';
import * as firebase from 'firebase';

import { News } from 'src/app/shared/news.model';
import { ActivatedRoute } from '@angular/router';
import * as moment from 'moment';
import { Location } from '@angular/common';
import { CanComponentDeactivate } from './can-deactivate-guard.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-article-alter',
  templateUrl: './article-alter.component.html',
  styleUrls: ['./article-alter.component.sass'],
})
export class ArticleAlterComponent implements OnInit, CanComponentDeactivate {
  separatorKeysCodes = [ENTER, COMMA];
  articleId = this.activatedRoute.snapshot.paramMap.get('id');
  labels: string[];
  tags = [];
  getFrom = 'news';
  getNews: News;
  addNews: FormGroup;
  uploadPorgress = 0;
  changesSaved: boolean;
  constructor(
    private dataService: DataService,
    private form: FormBuilder,
    private activatedRoute: ActivatedRoute,
    private location: Location
  ) {}

  ngOnInit() {
    this.labels = this.dataService.labels;
    this.addNews = this.form.group({
      'title': null,
      'tags': null,
      'labels': null,
      'time': this.form.group({
        // add: '',
        'add': {value: '', disabled: true}
      }),
      'content': null,
    });
    this.getNewsContent();
  }
  getNewsContent() {
    this.dataService.getData(this.getFrom, this.articleId)
    .then((doc) => {
      if (doc.exists) {
        this.getNews = <News>doc.data();
        this.addNews.patchValue({
          'title': this.getNews.title,
          'labels': this.getNews.labels[0],
          'time': {
            'add': moment(doc.data().time.add),
          },
          'content': this.getNews.content,
        });
        for (const value of this.getNews.tags) {
            this.tags.push(value);
        }
      }
    });
  }
  removeTag(tagName: string) {
    this.tags = this.tags.filter(tag => tag !== tagName);
  }
  addTag($event: MatChipInputEvent) {
    if (($event.value || '').trim()) {
      const value = $event.value.trim();
      if (this.tags.indexOf(value) === -1) {
        this.tags.push(value);
      }
    }
    $event.input.value = '';
  }
  sendValue() {
    this.addNews.patchValue({
      tags: this.tags,
    });
    const addNewsValue = {...this.addNews.getRawValue()};
    addNewsValue.time.edit = [];
    for (const valuexx of this.getNews.time.edit) {
      addNewsValue.time.edit.push(valuexx);
    }
    addNewsValue.time.edit.push(new Date().getTime());
    addNewsValue.time.add = addNewsValue.time.add.valueOf();
    const label = addNewsValue.labels;
    addNewsValue.labels = [label];
    this.dataService.updateData(this.getFrom, this.articleId, addNewsValue);
    this.addNews.reset();
    this.tags = [];
    this.location.back();
  }
  uploadImg($event) {
    const vm = this;
    const file = $event.target.files[0];
    const folderName = this.articleId;
    const uploadTask = firebase.storage().ref().child(`${this.getFrom}/${folderName}/${file.name}`).put(file);
    uploadTask.on('state_changed', (snapshot: any) => {
      this.uploadPorgress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    }, function(error) {
      console.error(error);
    }, function() {
      // Handle successful uploads on complete
      // For instance, get the download URL: https://firebasestorage.googleapis.com/...
      uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
        firebase.firestore().collection(vm.getFrom).doc(vm.articleId).update({imagePath: downloadURL});
      });
    });
  }
  canDeactivate(): Observable<boolean> | Promise<boolean> | boolean {

    if (this.addNews.dirty && this.addNews.touched) {
      return confirm('do you wnat to leave');
    } else {
      return true;
    }
  }
}
