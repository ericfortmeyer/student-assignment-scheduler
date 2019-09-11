import { Component, Directive } from '@angular/core';
import { FormGroup, Validators, NG_VALIDATORS, FormBuilder, FormControl } from '@angular/forms';
import { map, mergeMap } from 'rxjs/operators';
import { of, Observable, combineLatest } from 'rxjs';
import { ContactService } from 'src/app/services/contact.service';
import { ContactFormData } from 'src/app/contact-form-data';
import { Contact } from 'src/app/contact';
import { Router } from '@angular/router';

@Component({
  selector: 'app-create-contacts',
  templateUrl: './create-contacts.component.html',
  styleUrls: ['./create-contacts.component.css']
})

@Directive({
  providers: [{provide: NG_VALIDATORS, useExisting: Validators, multi: true}]
})
export class CreateContactsComponent {
  public createContactForm: FormGroup;
  public formSubmitResultObs$: Observable<Contact>;
  public hasFormSubmitted: boolean = false;
  constructor(
    private fb: FormBuilder,
    private router: Router,
    private contactService: ContactService,
  ) {
    this.createForm();
  }
  get firstName() { return this.createContactForm.get('firstName'); }
  get lastName() { return this.createContactForm.get('lastName'); }
  get email() { return this.createContactForm.get('email'); }
  createForm(): void {
    this.createContactForm = this.fb.group({
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      email: ['', Validators.required]
    });
  }
  hasError = (field: any): boolean => field.invalid && ( field.dirty || field.touched );
  formCompleted = (fields: FormControl[]): Observable<boolean> => {
    return combineLatest<FormControl[]>(fields.map(field => of(field))).pipe<boolean>(
      map(([a, b, c]) => (a.valid && b.valid && c.valid)),
    );
  }
  gotoContacts(delayInSeconds: number = 2) {
    setTimeout(
      () => this.router.navigate(['/contacts']),
      delayInSeconds * 1000
    );
  }
  onSubmit() {
    this.hasFormSubmitted = true;
    this.formSubmitResultObs$ = this.contactService.createContact(this.createContactForm.value as ContactFormData);
    this.createContactForm.reset();
  }
}
