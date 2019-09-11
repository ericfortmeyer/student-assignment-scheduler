import { SpecialEvent } from './special-event';

export class SpecialEventsPayload {
    _embedded: {
        specialEvents: SpecialEvent[];
    };
}
