import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ArticleListComponent } from './article-list/article-list.component';
import { ArticleAlterComponent } from './article-alter/article-alter.component';
import { ArticleContentComponent } from './article-content/article-content.component';
import { ShareMatModule } from '../shared/shareMat.module';
import { ComponentsModule } from '../components/components.module';
import { ArticleRoutingModule } from './app-ArticleRouting.module';
import { ReactiveFormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    ArticleListComponent,
    ArticleAlterComponent,
    ArticleContentComponent,
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ComponentsModule,
    ShareMatModule,
    ArticleRoutingModule,
  ]
})
export class ArticleModule { }
