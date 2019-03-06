import { Component, OnInit, Input } from '@angular/core';
import { News } from 'src/app/shared/news.model';

@Component({
  selector: 'app-normal-title',
  templateUrl: './normal-title.component.html',
  styleUrls: ['./normal-title.component.sass']
})
export class NormalTitleComponent implements OnInit {
  @Input() inputNews: News;
  constructor() { }

  ngOnInit() {
  }

}
