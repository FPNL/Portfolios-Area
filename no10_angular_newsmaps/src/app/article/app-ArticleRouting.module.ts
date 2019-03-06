import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ArticleListComponent } from './article-list/article-list.component';
import { ArticleAlterComponent } from './article-alter/article-alter.component';
import { ArticleContentComponent } from './article-content/article-content.component';
import { CanDeactivateGuardService } from './article-alter/can-deactivate-guard.service';
import { AuthGuardService } from './article-alter/auth-guard.service';

const routes: Routes = [
  {
    path: '',
    children: [
      { path: 'search', component: ArticleListComponent },
      {
        path: 'alter/:id',
        component: ArticleAlterComponent,
        canDeactivate: [CanDeactivateGuardService],
        canActivate: [AuthGuardService],
      },
      { path: ':id', component: ArticleContentComponent },
      { path: '', redirectTo: '/', pathMatch: 'full' },
      { path: '**', redirectTo: '/' },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ArticleRoutingModule {}
