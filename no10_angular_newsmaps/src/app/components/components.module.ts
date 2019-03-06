import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserTitleComponent } from './user-title/user-title.component';
import { TopTitleComponent } from './top-title/top-title.component';
import { TitleContentComponent } from './title-content/title-content.component';
import { SideBarComponent } from './side-bar/side-bar.component';
import { NormalTitleComponent } from './normal-title/normal-title.component';
import { ShareMatModule } from '../shared/shareMat.module';
import { RouterModule } from '@angular/router';

@NgModule({
  declarations: [
    UserTitleComponent,
    TopTitleComponent,
    TitleContentComponent,
    SideBarComponent,
    NormalTitleComponent,
  ],
  imports: [
    CommonModule,
    ShareMatModule,
    RouterModule,
  ],
  exports: [
    TopTitleComponent,
    SideBarComponent,
    TitleContentComponent,
    NormalTitleComponent,
    UserTitleComponent,
  ]
})
export class ComponentsModule { }
