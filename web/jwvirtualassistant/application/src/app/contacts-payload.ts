import { Contact } from './contact';

export class ContactsPayload {
    _embedded: {
        contacts: Contact[];
    };
}
