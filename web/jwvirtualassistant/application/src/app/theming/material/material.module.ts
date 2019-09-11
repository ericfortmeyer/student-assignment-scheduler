import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MatSidenavModule } from '@angular/material/sidenav';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatIconModule, MatIconRegistry } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { MatRippleModule, ErrorStateMatcher } from '@angular/material/core';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatProgressBarModule } from '@angular/material/progress-bar';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { DomSanitizer } from '@angular/platform-browser';
import { CustomErrorStateMatcher } from './forms/error-state/custom-error-state-matcher';

@NgModule({
  declarations: [],
  imports: [
    CommonModule
  ],
  exports: [
    MatSidenavModule,
    MatToolbarModule,
    MatIconModule,
    MatListModule,
    MatCardModule,
    MatButtonModule,
    MatRippleModule,
    MatFormFieldModule,
    MatInputModule,
    MatProgressBarModule,
    MatProgressSpinnerModule
  ],
  providers: [
    {provide: ErrorStateMatcher, useClass: CustomErrorStateMatcher}
  ]
})
export class MaterialModule {
  constructor(iconRegistry: MatIconRegistry, sanitizer: DomSanitizer) {
    iconRegistry
      .addSvgIcon(
        'menu',
        sanitizer.bypassSecurityTrustResourceUrl('assets/images/baseline-menu-24px.svg')
      ).addSvgIcon(
        'add',
        sanitizer.bypassSecurityTrustResourceUrl('assets/images/baseline-add-24px.svg')
      ).addSvgIcon(
        'edit',
        sanitizer.bypassSecurityTrustResourceUrl('assets/images/baseline-edit-24px.svg')
      ).addSvgIcon(
        'person_add',
        sanitizer.bypassSecurityTrustResourceUrl('assets/images/baseline-person_add-24px.svg')
      ).addSvgIcon(
        'email',
        sanitizer.bypassSecurityTrustResourceUrl('assets/images/baseline-email-24px.svg')
      );
  }
 }
