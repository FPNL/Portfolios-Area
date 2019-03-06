import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
// import { LoginComponent } from './login/login.component';
import { MainComponent } from './main/main.component';

const routes: Routes = [
  // {path: 'login', component: LoginComponent},
  {path: 'login', loadChildren: './login/login.module#LoginModule'},
  {path: 'article', loadChildren: './article/article.module#ArticleModule'},
  {path: '', component: MainComponent, pathMatch: 'full'},
  {path: '**', redirectTo: '/'},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
