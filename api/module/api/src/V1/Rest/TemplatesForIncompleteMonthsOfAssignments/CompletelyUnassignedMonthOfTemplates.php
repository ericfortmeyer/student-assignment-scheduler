<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

use StudentAssignmentScheduler\MonthOfAssignments;
use StudentAssignmentScheduler\ListOfContacts;

class CompletelyUnassignedMonthOfTemplates extends AbstractUnassignedMonthOfTemplates
{
    /**
     * @var bool
     */
    public $completelyUnassigned = true;

    /**
     * Create the instance.
     * 
     * @param MonthOfAssignments $month_of_assignments
     * @param ListOfContacts $contacts
     */
    public function __construct(MonthOfAssignments $month_of_assignments, ListOfContacts $contacts)
    {
        parent::__construct($month_of_assignments, $contacts);
    }
}
