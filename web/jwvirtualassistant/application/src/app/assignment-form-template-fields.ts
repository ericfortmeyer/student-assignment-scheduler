import { AssignmentFormTemplateFieldsType } from './assignment-form-template-fields-type';
import { Assignment } from './assignment';

export class AssignmentFormTemplateFields {
    required: Array<AssignmentFormTemplateFieldsType>;
    optional: Array<AssignmentFormTemplateFieldsType>;
    prepopulated: Assignment;
}
