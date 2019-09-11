import { Component, Directive, OnInit } from '@angular/core';
import { FormGroup, Validators, NG_VALIDATORS, FormBuilder, FormControl } from '@angular/forms';
import { map, switchMap, tap, first, mergeMap } from 'rxjs/operators';
import { of, Observable, combineLatest } from 'rxjs';
import { ContactService } from 'src/app/services/contact.service';
import { ContactFormData } from 'src/app/contact-form-data';
import { Contact } from 'src/app/contact';
import { Router, ActivatedRoute, ParamMap } from '@angular/router';

@Component({
  selector: 'app-update-contacts',
  templateUrl: './update-contacts.component.html',
  styleUrls: ['./update-contacts.component.css']
})

@Directive({
  providers: [{provide: NG_VALIDATORS, useExisting: Validators, multi: true}]
})

export class UpdateContactsComponent implements OnInit {
  public updateContactForm: FormGroup;
  public formSubmitResultObs$: Observable<Contact>;
  public contact$: Observable<Contact>;
  constructor(
    private fb: FormBuilder, 
    private router: Router,
    private route: ActivatedRoute,
    private contactService: ContactService, 
  ) {}

  ngOnInit() {
    this.contact$ = this.route.paramMap.pipe(
      switchMap( (params: ParamMap) =>
        this.contactService.getContactById(params.get('id'))
      ),
      tap(
        (contact: Contact) => this.createForm(contact)
      )
    );
  }
  get firstName() { return this.updateContactForm.get('firstName'); }
  get lastName() { return this.updateContactForm.get('lastName'); }
  get email() { return this.updateContactForm.get('email'); }
  createForm(contact: Contact): void {
    this.updateContactForm = this.fb.group({
      firstName: [contact.firstName, Validators.required],
      lastName: [contact.lastName, Validators.required],
      email: [contact.email, Validators.required]
    })
  }
  hasError = (field: any): boolean => field.invalid && ( field.dirty || field.touched );
  formCompleted = (fields: FormControl[]): Observable<boolean> => {
    return combineLatest<FormControl[]>(fields.map(field => of(field))).pipe<boolean>(
      map(([a, b, c]) => (a.valid && b.valid && c.valid && (a.dirty || b.dirty || c.dirty))),
    );
  }
  gotoContacts(delayInSeconds: number = 2) {
    setTimeout(
      () => this.router.navigate(['/contacts']),
      delayInSeconds * 1000
    );
  }
  onSubmit() {
    this.formSubmitResultObs$ = this.route.paramMap.pipe(
      first((params: ParamMap) => params.has('id')),
      mergeMap((params: ParamMap) => 
        this.contactService.updateContact(params.get('id'), this.updateContactForm.value as ContactFormData)
      )
    );
    this.gotoContacts(3);
  }
}
