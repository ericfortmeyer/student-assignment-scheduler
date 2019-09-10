<?php
namespace api\V1\Rest\Schedule_recipients;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

use \Ds\Map;
use \StudentAssignmentScheduler\ListOfScheduleRecipients;
use \StudentAssignmentScheduler\ScheduleRecipient;
use \StudentAssignmentScheduler\Guid;
use function StudentAssignmentScheduler\Commands\Functions\addContact;
use function StudentAssignmentScheduler\Querying\Functions\fetchScheduleRecipients;
use function StudentAssignmentScheduler\Commands\Functions\updateContact;
use function StudentAssignmentScheduler\Commands\Functions\deleteContact;


class Schedule_recipientsResource extends AbstractResourceListener
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $contact_info = (new Map((array) $data))->values()->join(" ");

        try {
            $contact = new ScheduleRecipient($contact_info);
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        return addContact($contact, ListOfScheduleRecipients::class)
            ? $contact->getArrayCopy()
            : new ApiProblem(417, sprintf("Contact not created. %s", json_encode((array) $data)));
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $guid = new Guid($id);
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        return deleteContact($guid, ListOfScheduleRecipients::class)
            || new ApiProblem(404, "Resource with id, ${guid}, not found.");
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
        try {
            $guid = new Guid((string) $id);
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        $stubForErrorHandling = function () use ($guid): object {
            return new class($guid) {
                protected $guid;
                public function __construct(Guid $guid)
                {
                    $this->guid = $guid;
                }
                public function getArrayCopy(): ApiProblem
                {
                    return new ApiProblem(404, "Resource with id, {$this->guid}, not found.");
                }
            };
        };

        return fetchScheduleRecipients()
            ->findByGuid($guid)
            ->getOrElse($stubForErrorHandling)
            ->getArrayCopy();
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return fetchScheduleRecipients()->getArrayCopy();
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
        $contact_info = (new Map((array) $data))->values()->join(" ");

        try {
            $guid = new Guid((string) $id);
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        try {
            $updated_contact = new ScheduleRecipient($contact_info);
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        return updateContact($guid, $updated_contact, ListOfScheduleRecipients::class)
            ? $updated_contact->getArrayCopy()
            : new ApiProblem(404, sprintf("Contact with id '%s' not found", (string) $guid));
    }
}
