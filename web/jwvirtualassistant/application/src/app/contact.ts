import { Guid } from './guid';
import { Fullname } from './fullname';
import { FirstName } from './first-name';
import { LastName } from './last-name';
import { Email } from './email';

export class Contact {
    id: Guid;
    fullname: Fullname;
    firstName: FirstName;
    lastName: LastName;
    email: Email;
}
