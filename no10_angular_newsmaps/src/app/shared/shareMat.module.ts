import { NgModule } from '@angular/core';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatIconModule} from '@angular/material/icon';
import {MatChipsModule} from '@angular/material/chips';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatInputModule} from '@angular/material/input';
import {MatCardModule} from '@angular/material/card';
import {MatButtonModule} from '@angular/material/button';
import {MatGridListModule} from '@angular/material/grid-list';
import {MatDividerModule} from '@angular/material/divider';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatMomentDateModule} from '@angular/material-moment-adapter';
import { MAT_DATE_LOCALE } from '@angular/material/core';
import {MatAutocompleteModule} from '@angular/material/autocomplete';
import {MatSelectModule} from '@angular/material/select';
import {MatProgressBarModule} from '@angular/material/progress-bar';
import {MatProgressSpinnerModule} from '@angular/material/progress-spinner';

// import {MatBottomSheetModule} from '@angular/material/bottom-sheet';
@NgModule({
  exports: [
    MatToolbarModule,
    MatIconModule,
    MatChipsModule,
    MatSlideToggleModule,
    MatFormFieldModule,
    MatInputModule,
    MatCardModule,
    MatButtonModule,
    MatGridListModule,
    MatDividerModule,
    MatDatepickerModule,
    MatMomentDateModule,
    MatAutocompleteModule,
    MatSelectModule,
    MatProgressBarModule,
    MatProgressSpinnerModule,
    // MatBottomSheetModule,
  ],
  providers: [
    {provide: MAT_DATE_LOCALE, useValue: 'zh-TW'}
  ],
})
export class ShareMatModule { }
