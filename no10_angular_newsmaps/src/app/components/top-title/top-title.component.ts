import { Component, OnInit, Input } from '@angular/core';
import { News } from 'src/app/shared/news.model';

@Component({
  selector: 'app-top-title',
  templateUrl: './top-title.component.html',
  styleUrls: ['./top-title.component.sass']
})
export class TopTitleComponent implements OnInit {
  @Input() inputNews: News;
  constructor() { }

  ngOnInit() {
  }

}
