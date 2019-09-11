import { SpecialEventType } from './special-event-type';
import { Guid } from './guid';

export class SpecialEvent {
    id: Guid;
    date: Date;
    type: SpecialEventType;
}
