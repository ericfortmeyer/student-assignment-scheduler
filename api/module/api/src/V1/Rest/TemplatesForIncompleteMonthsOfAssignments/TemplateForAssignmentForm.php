<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

use StudentAssignmentScheduler\Assignment;
use StudentAssignmentScheduler\Date;

/**
 * Used by clients to create forms.
 * 
 * The forms will be used to make assignments.
 */
class TemplateForAssignmentForm
{
    public $fields = [
        "required" => [
            "name", //name of the student
            "assistant" //name of the assistant
        ],
        "optional" => [
            "counsel_point" //leave blank
        ]
    ];
    
    /**
     * @var array<string,string>
     */
    public $prepopulated = [
        "date" => "",
        "assignment" => "", //name of the assignment
        "number" => "" //used to determine ordering of the assignments in the schedule
    ];

    /**
     * Create the instance.
     */
    public function __construct(
        Date $date,
        Assignment $assignment_info
    ) {
        $this->prepopulated["date"] = $date->asText();
        $this->prepopulated["assignment"] = (string) $assignment_info;
        $this->prepopulated["number"] = (string) $assignment_info->number();
    }
}
