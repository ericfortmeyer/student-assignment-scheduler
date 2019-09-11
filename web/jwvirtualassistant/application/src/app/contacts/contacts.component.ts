import { Component, OnDestroy } from '@angular/core';
import { ContactService } from '../services/contact.service';
import { Observable, Subject, of, combineLatest, Subscription } from 'rxjs';
import { map, filter, takeLast } from 'rxjs/operators';
import { Contact } from '../contact';
import { Guid } from '../guid';

@Component({
  selector: 'app-contacts',
  styleUrls: ['./contacts.component.css'],
  templateUrl: './contacts.component.html'
})

export class ContactsComponent implements OnDestroy {
  public contactsObs$: Observable<Contact[]>;
  private sub: Subscription;
  constructor(private contactService: ContactService) {
    this.contactsObs$ = this.contactService.getContacts().pipe(
      map(payload => payload._embedded.contacts.map(contact => contact))
    );
  }
  deleteContact(id: Guid): void {
    this.contactService.deleteContact(id).toPromise().then(
      () => {
        this.sub = this.contactsObs$.subscribe(
          (contacts: Contact[]) => {
            const contactsAfterDeleteObs$ = of(contacts.filter( (c: Contact) => c.id !== id))
            this.contactsObs$ = contactsAfterDeleteObs$;
          }
        );
      }
    ).catch( () => alert('Sorry there seems to be something wrong on our end.  Please try again later'));
  }
  ngOnDestroy() {
    this.sub && this.sub.unsubscribe();
  }
}
