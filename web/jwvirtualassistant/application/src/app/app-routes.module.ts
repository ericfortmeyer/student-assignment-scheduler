import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ContactsComponent } from './contacts/contacts.component';
import { ScheduleRecipientsComponent } from './schedule-recipients/schedule-recipients.component';
import { SpecialEventsComponent } from './special-events/special-events.component';
import { FormTemplatesComponent } from './form-templates/templates-for-incomplete-months-of-assignments.component';
import { WelcomeScreenComponent } from './welcome-screen/welcome-screen.component';
import { CreateContactsComponent } from './contacts/create-contacts/create-contacts.component';
import { UpdateContactsComponent } from './contacts/update-contacts/update-contacts.component';

const appRoutes: Routes = [
  { path: '', component: WelcomeScreenComponent },
  { path: 'contacts', component: ContactsComponent },
  { path: 'contacts/create', component: CreateContactsComponent },
  { path: 'contacts/update/:id', component: UpdateContactsComponent },
  { path: 'schedule-recipients', component: ScheduleRecipientsComponent },
  { path: 'special-events', component: SpecialEventsComponent },
  { path: 'assignments/assign', component: FormTemplatesComponent },
];

@NgModule({
  declarations: [],
  imports: [
    RouterModule.forRoot(appRoutes),
  ],
  exports: [
    RouterModule
  ],
})
export class AppRoutesModule { }
