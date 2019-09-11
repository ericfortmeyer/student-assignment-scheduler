import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ContactsPayload } from '../contacts-payload';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Contact } from '../contact';
import { ContactFormData } from '../contact-form-data';
import { Guid } from '../guid';

@Injectable({
  providedIn: 'root'
})

export class ContactService {
  private contactsUrl = `${environment.host}:${environment.port}/contacts`;
  constructor(private http: HttpClient) {}
  getContacts = (): Observable<ContactsPayload> => this.http.get<ContactsPayload>(this.contactsUrl);
  getContactById = (id: string): Observable<Contact> => this.http.get<Contact>(`${this.contactsUrl}/${id}`);
  createContact = (data: ContactFormData): Observable<Contact> => this.http.post<Contact>(this.contactsUrl, data);
  updateContact = (id: string, data: ContactFormData): Observable<Contact> => this.http.put<Contact>(`${this.contactsUrl}/${id}`, data);
  deleteContact = (id: Guid): Observable<Contact> => this.http.delete<Contact>(`${this.contactsUrl}/${id}`);
}
