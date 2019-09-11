<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

use StudentAssignmentScheduler\MonthOfAssignments;
use StudentAssignmentScheduler\WeekOfAssignments;
use StudentAssignmentScheduler\Assignment;
use StudentAssignmentScheduler\Date;
use StudentAssignmentScheduler\ListOfContacts;
use \Ds\Vector;
use Zend\Uri\Uri;

abstract class AbstractUnassignedMonthOfTemplates
{
    protected const RESOURCE = "assignments";
    protected const URI_PATH_SEPARATOR = "/";
    
    public $method = "post";
    public $target = "";

    /**
     * @var Vector
     */
    public $monthOfAssignmentFormTemplates;

    /**
     * @var ListOfContacts
     */
    public $contacts;

    /**
     * Create the instance.
     * 
     * @param MonthOfAssignments $month_of_assignments
     * @param ListOfContacts $contacts
     */
    public function __construct(
        MonthOfAssignments $month_of_assignments,
        ListOfContacts $contacts
    ) {
        $this->setTarget($month_of_assignments);
        $this->setTemplates($month_of_assignments);
        $this->contacts = $contacts;
    }

    private function setTemplates(MonthOfAssignments $month_of_assignments): void
    {
        $createTemplates = function (
            Date $date,
            WeekOfAssignments $week
        ): WeekOfAssignments {
            return $week->map(
                function (int $index, Assignment $assignment) use ($date): TemplateForAssignmentForm {
                    return new TemplateForAssignmentForm($date, $assignment);
                }
            );
        };

        $this->monthOfAssignmentFormTemplates = new Vector($month_of_assignments->weeks()->map($createTemplates));
    }

    private function setTarget(MonthOfAssignments $month_of_assignments): void
    {
        $uri = new Uri();
        $resource_id = (string) $month_of_assignments->year() . (string) $month_of_assignments->month();
        $relativePath = join(
            self::URI_PATH_SEPARATOR,
            [self::RESOURCE, $resource_id]
        );
        $uri->setPath($relativePath);
        $this->target = (string) $uri;
    }
}
