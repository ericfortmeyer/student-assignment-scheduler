<?php
namespace api\V1\Rest\Special_events;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
// use Zend\Http\Response;

use \Ds\Map;

use StudentAssignmentScheduler\{
    SpecialEvent,
    Guid,
    Date,
    Month,
    DayOfMonth,
    Year,
    SpecialEventType,
    ExtendedDateTimeImmutable
};
use StudentAssignmentScheduler\Exception\{
    InvalidSpecialEventTypeException,
    InvalidDateTypeArgumentException,
    InvalidDateInputException
};

use \InvalidArgumentException;

use function StudentAssignmentScheduler\Commands\Functions\addSpecialEvent;
use function \StudentAssignmentScheduler\Commands\Functions\removeSpecialEvent;
use function \StudentAssignmentScheduler\Commands\Functions\updateSpecialEvent;
use function \StudentAssignmentScheduler\Querying\Functions\fetchSpecialEvents;
use function \StudentAssignmentScheduler\Utils\Functions\getConfig;

class Special_eventsResource extends AbstractResourceListener
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $Map = new Map((array) $data);

        if (!$Map->hasKey("date") && !$Map->hasKey("type")) {
            $error_message = sprintf("Missing required fields.  Please enter the '%s' and '%s' of the event.", "date", "type");
            return new ApiProblem(400, $error_message);
        }

        try {
            $event_type = new SpecialEventType(
                getConfig()["special_events"],
                $Map->get("type")
            );
            $dt = new ExtendedDateTimeImmutable($Map->get("date"));
            $date = new Date(
                $month = new Month($dt->format("m")), 
                new DayOfMonth($month, $dt->format("d")), 
                new Year($dt->format("Y"))
            );

        } catch (InvalidSpecialEventTypeException | InvalidDateTypeArgumentException | InvalidDateInputException $e) {
            return new ApiProblem(400, $e->getMessage());
        }

        $special_event = new SpecialEvent($date, $event_type);
        addSpecialEvent($special_event);

        return $special_event->getArrayCopy();
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
        return removeSpecialEvent($guid);
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
        return fetchSpecialEvents()->getArrayCopy();
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
        $Map = new Map((array) $data);

        if (!$Map->hasKey("date") && !$Map->hasKey("type")) {
            $error_message = sprintf("Missing required fields.  Please enter the '%s' and '%s' of the event.", "date", "type");
            return new ApiProblem(400, $error_message);
        }

        try {
            $event_type = new SpecialEventType(
                getConfig()["special_events"],
                $Map->get("type")
            );
            $dt = new ExtendedDateTimeImmutable($Map->get("date"));
            $date = new Date(
                $month = new Month($dt->format("m")), 
                new DayOfMonth($month, $dt->format("d")), 
                new Year($dt->format("Y"))
            );

            $guid = new Guid($id);

        } catch (
            InvalidSpecialEventTypeException | InvalidDateTypeArgumentException | InvalidDateInputException | InvalidArgumentException $e
        ) {
            return new ApiProblem(400, $e->getMessage());
        }

        $event_modified = new SpecialEvent($date, $event_type);

        return updateSpecialEvent($guid, $event_modified);
    }
}
