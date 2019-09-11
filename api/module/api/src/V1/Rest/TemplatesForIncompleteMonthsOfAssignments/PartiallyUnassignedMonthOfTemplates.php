<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

use StudentAssignmentScheduler\MonthOfAssignments;
use StudentAssignmentScheduler\WeekOfAssignments;
use StudentAssignmentScheduler\Date;
use StudentAssignmentScheduler\ListOfContacts;
use \Ds\Vector;

class PartiallyUnassignedMonthOfTemplates extends AbstractUnassignedMonthOfTemplates
{
    /**
     * @var bool $compeletlyUnassigned
     */
    public $compeletlyUnassigned = false;

    /**
     * Create the instance.
     * 
     * @param MonthOfAssignments $month_of_assignments
     * @param Vector $dates_of_weeks_containing_assignments_already_made
     * @param ListOfContacts $contacts
     */
    public function __construct(
        MonthOfAssignments $month_of_assignments,
        Vector $dates_of_weeks_containing_assignments_already_made,
        ListOfContacts $contacts
    ) {

        $assignmentsHaveAlreadyBeenMadeInWeek = function (
            Date $date, 
            WeekOfAssignments $week
        ) use ($dates_of_weeks_containing_assignments_already_made): bool {
            return !$dates_of_weeks_containing_assignments_already_made
                ->contains((string) $date);
        };

        parent::__construct(
            $month_of_assignments->filter($assignmentsHaveAlreadyBeenMadeInWeek),
            $contacts
        );
    }
}
