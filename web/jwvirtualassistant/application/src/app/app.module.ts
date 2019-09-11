import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgModule } from '@angular/core';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { ContactsComponent } from './contacts/contacts.component';
import { ScheduleRecipientsComponent } from './schedule-recipients/schedule-recipients.component';
import { SpecialEventsComponent } from './special-events/special-events.component';
import { FormTemplatesComponent } from './form-templates/templates-for-incomplete-months-of-assignments.component';
import { SplashScreenComponent } from './splash-screen/splash-screen.component';
import { AppTitleComponent } from './app-title/app-title.component';
import { WelcomeScreenComponent } from './welcome-screen/welcome-screen.component';
import { CreateContactsComponent } from './contacts/create-contacts/create-contacts.component';
import { UpdateContactsComponent } from './contacts/update-contacts/update-contacts.component';
import { CreatedPopupComponent } from './popups/created/created.component';
import { DeletedPopupComponent } from './popups/deleted/deleted.component';
import { UpdatedPopupComponent } from './popups/updated/updated.component';

import { AuthorizationTokenService } from './services/authorization-token.service';
import { ResourceRequestInterceptor } from './services/interceptors/resource-request.interceptor';
import { AppRoutesModule } from './app-routes.module';

import { NgxTrimDirectiveModule } from 'ngx-trim-directive';
import { MaterialModule } from './theming/material/material.module';
import { CenteredSpinnerComponent } from './theming/material/spinners/centered-spinner/centered-spinner.component';
import { provideRoutes } from '@angular/router';
import { TokenHandler } from 'src/lib/token-handler';

@NgModule({
  declarations: [
    AppComponent,
    ContactsComponent,
    ScheduleRecipientsComponent,
    SpecialEventsComponent,
    FormTemplatesComponent,
    SplashScreenComponent,
    AppTitleComponent,
    WelcomeScreenComponent,
    CreateContactsComponent,
    UpdateContactsComponent,
    CreatedPopupComponent,
    DeletedPopupComponent,
    UpdatedPopupComponent,
    CenteredSpinnerComponent
  ],
  imports: [
    BrowserModule,
    ReactiveFormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    AppRoutesModule,
    NgxTrimDirectiveModule,
    MaterialModule
  ],
  providers: [
    AuthorizationTokenService,
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ResourceRequestInterceptor,
      multi: true
    },
    TokenHandler
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
