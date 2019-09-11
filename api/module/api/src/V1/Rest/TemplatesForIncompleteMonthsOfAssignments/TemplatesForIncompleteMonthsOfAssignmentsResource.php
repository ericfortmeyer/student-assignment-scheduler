<?php
namespace api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

use function StudentAssignmentScheduler\Querying\Functions\fetchDatesOfWeeksContainingCreatedAssignments;
use function StudentAssignmentScheduler\Querying\Functions\fetchMonthOfAssignments;
use function StudentAssignmentScheduler\Querying\Functions\fetchContacts;
use \StudentAssignmentScheduler\Month;
use \StudentAssignmentScheduler\Year;
use \DateTimeImmutable;
use \DateInterval;

class TemplatesForIncompleteMonthsOfAssignmentsResource extends AbstractResourceListener
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        // default: 3 months of assignments
        $numMonths = $params["numMonths"] ?? 3;
        $months = (new \Ds\Vector(range(0, $numMonths - 1)))->map(
            function (int $months_to_add) {
                $dt = DateTimeImmutable::createFromFormat("m", 3);
                return (new DateTimeImmutable())->add(new DateInterval("P${months_to_add}M"));
            }
        );

        $containsFormTemplates = function (AbstractUnassignedMonthOfTemplates $templates): bool {
            return !$templates->monthOfAssignmentFormTemplates->isEmpty();
        };

        return $months->map(
            function (DateTimeImmutable $dt): AbstractUnassignedMonthOfTemplates {
                $month = new Month($dt->format("m"));
                $year = new Year($dt->format("Y"));
                $month_of_assignments = fetchMonthOfAssignments(
                    $month,
                    $year
                );
                $dates_of_weeks_containing_assignments_already_made = fetchDatesOfWeeksContainingCreatedAssignments(
                    $month,
                    $year
                );
                $contacts = fetchContacts();
        
                return $dates_of_weeks_containing_assignments_already_made->isEmpty()
                    ? new CompletelyUnassignedMonthOfTemplates($month_of_assignments, $contacts)
                    : new PartiallyUnassignedMonthOfTemplates(
                        $month_of_assignments,
                        $dates_of_weeks_containing_assignments_already_made,
                        $contacts
                    );
            }
        )->filter($containsFormTemplates);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
