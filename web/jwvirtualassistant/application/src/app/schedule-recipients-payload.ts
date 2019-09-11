import { ScheduleRecipient } from './schedule-recipient';

export class ScheduleRecipientsPayload {
    _embedded: {
        scheduleRecipients: ScheduleRecipient[];
    };
}
