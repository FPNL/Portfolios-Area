import { Component, OnInit, Input, OnChanges } from '@angular/core';
import { UserInterface } from 'src/app/shared/news.model';
import { DataService } from 'src/app/shared/data.service';

@Component({
  selector: 'app-user-title',
  templateUrl: './user-title.component.html',
  styleUrls: ['./user-title.component.sass'],
})
export class UserTitleComponent implements OnInit, OnChanges {
  @Input() inputUser: UserInterface;
  avatar: string;
  nrandom: number;
  constructor(private dataService: DataService) {}

  ngOnInit() {
    this.nrandom = Math.floor(Math.random() * 10);
  }
  ngOnChanges() {
    this.dataService.getWhereDatas('users', 'account', '==', this.inputUser.account)
      .then(queryDoc => {
        queryDoc.forEach(doc => {
          this.avatar = doc.data().avatarPath;
        });
      });
  }
}
