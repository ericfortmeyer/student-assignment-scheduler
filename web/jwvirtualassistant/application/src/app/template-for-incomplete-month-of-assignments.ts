import { AssignmentFormTemplate } from './assignment-form-template';
import { Contact } from './contact';
import { HttpMethods } from './http-methods';
import { UriPath } from './uri-path';

export class TemplateForIncompleteMonthOfAssignments {
    completelyUnassigned: boolean;
    method: HttpMethods;
    target: UriPath;
    monthOfAssignmentFormTemplates: AssignmentFormTemplate;
    contacts: Array<Contact>;
}
