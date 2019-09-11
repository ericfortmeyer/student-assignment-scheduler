import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
/* tslint:disable-next-line:max-line-length */
import { TemplateForIncompleteMonthsOfAssignmentsPayload as TemplatesPayload } from '../template-for-incomplete-months-of-assignments-payload';

@Injectable({
  providedIn: 'root'
})

export class TemplatesForIncompleteMonthsOfAssignmentsService {
  private path = 'templates-for-incomplete-months-of-assignments';
  private formTemplatesUrl = `${environment.host}:${environment.port}/${this.path}`;
  constructor(private http: HttpClient) { }
  getFormTemplates = (): Observable<TemplatesPayload> => this.http.get<TemplatesPayload>(this.formTemplatesUrl);
}
