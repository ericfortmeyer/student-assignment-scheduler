<?php
return [
    'service_manager' => [
        'factories' => [
            \api\V1\Rest\Assignments\AssignmentsResource::class => \api\V1\Rest\Assignments\AssignmentsResourceFactory::class,
            \api\V1\Rest\Contacts\ContactsResource::class => \api\V1\Rest\Contacts\ContactsResourceFactory::class,
            \api\V1\Rest\Schedule_recipients\Schedule_recipientsResource::class => \api\V1\Rest\Schedule_recipients\Schedule_recipientsResourceFactory::class,
            \api\V1\Rest\Special_events\Special_eventsResource::class => \api\V1\Rest\Special_events\Special_eventsResourceFactory::class,
            \api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments\TemplatesForIncompleteMonthsOfAssignmentsResource::class => \api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments\TemplatesForIncompleteMonthsOfAssignmentsResourceFactory::class,
            \api\V1\Rest\Accounts\AccountsResource::class => \api\V1\Rest\Accounts\AccountsResourceFactory::class,
            \api\V1\Rest\TestSpecialEvents\TestSpecialEventsResource::class => \api\V1\Rest\TestSpecialEvents\TestSpecialEventsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'api.rest.assignments' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/assignments[/:assignments_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Assignments\\Controller',
                    ],
                ],
            ],
            'api.rest.contacts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/contacts[/:contacts_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Contacts\\Controller',
                    ],
                ],
            ],
            'api.rest.schedule_recipients' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/schedule_recipients[/:schedule_recipients_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Schedule_recipients\\Controller',
                    ],
                ],
            ],
            'api.rest.special_events' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/special_events[/:special_events_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Special_events\\Controller',
                    ],
                ],
            ],
            'api.rest.templates-for-incomplete-months-of-assignments' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/templates-for-incomplete-months-of-assignments[/:templates_for_incomplete_months_of_assignments_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller',
                    ],
                ],
            ],
            'api.rest.accounts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/accounts[/:accounts_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Accounts\\Controller',
                    ],
                ],
            ],
            'api.rest.test-special-events' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/accounts/:accounts_id/test-special-events[/:test_special_events_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\TestSpecialEvents\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'api.rest.assignments',
            1 => 'api.rest.contacts',
            2 => 'api.rest.schedule_recipients',
            3 => 'api.rest.special_events',
            4 => 'api.rest.templates-for-incomplete-months-of-assignments',
            5 => 'api.rest.accounts',
            6 => 'api.rest.test-special-events',
        ],
    ],
    'zf-rest' => [
        'api\\V1\\Rest\\Assignments\\Controller' => [
            'listener' => \api\V1\Rest\Assignments\AssignmentsResource::class,
            'route_name' => 'api.rest.assignments',
            'route_identifier_name' => 'assignments_id',
            'collection_name' => 'assignments',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [
                0 => 'completed',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\Assignments\AssignmentsEntity::class,
            'collection_class' => \api\V1\Rest\Assignments\AssignmentsCollection::class,
            'service_name' => 'assignments',
        ],
        'api\\V1\\Rest\\Contacts\\Controller' => [
            'listener' => \api\V1\Rest\Contacts\ContactsResource::class,
            'route_name' => 'api.rest.contacts',
            'route_identifier_name' => 'contacts_id',
            'collection_name' => 'contacts',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
                3 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\Contacts\ContactsEntity::class,
            'collection_class' => \api\V1\Rest\Contacts\ContactsCollection::class,
            'service_name' => 'contacts',
        ],
        'api\\V1\\Rest\\Schedule_recipients\\Controller' => [
            'listener' => \api\V1\Rest\Schedule_recipients\Schedule_recipientsResource::class,
            'route_name' => 'api.rest.schedule_recipients',
            'route_identifier_name' => 'schedule_recipients_id',
            'collection_name' => 'scheduleRecipients',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'DELETE',
                3 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\Schedule_recipients\Schedule_recipientsEntity::class,
            'collection_class' => \api\V1\Rest\Schedule_recipients\Schedule_recipientsCollection::class,
            'service_name' => 'schedule_recipients',
        ],
        'api\\V1\\Rest\\Special_events\\Controller' => [
            'listener' => \api\V1\Rest\Special_events\Special_eventsResource::class,
            'route_name' => 'api.rest.special_events',
            'route_identifier_name' => 'special_events_id',
            'collection_name' => 'specialEvents',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\Special_events\Special_eventsEntity::class,
            'collection_class' => \api\V1\Rest\Special_events\Special_eventsCollection::class,
            'service_name' => 'special_events',
        ],
        'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => [
            'listener' => \api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments\TemplatesForIncompleteMonthsOfAssignmentsResource::class,
            'route_name' => 'api.rest.templates-for-incomplete-months-of-assignments',
            'route_identifier_name' => 'templates_for_incomplete_months_of_assignments_id',
            'collection_name' => 'formTemplates',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'numMonths',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\TemplatesForIncompleteMonthsOfAssignmentsEntity',
            'collection_class' => \api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments\TemplatesForIncompleteMonthsOfAssignmentsCollection::class,
            'service_name' => 'TemplatesForIncompleteMonthsOfAssignments',
        ],
        'api\\V1\\Rest\\Accounts\\Controller' => [
            'listener' => \api\V1\Rest\Accounts\AccountsResource::class,
            'route_name' => 'api.rest.accounts',
            'route_identifier_name' => 'accounts_id',
            'collection_name' => 'accounts',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\Accounts\AccountsEntity::class,
            'collection_class' => \api\V1\Rest\Accounts\AccountsCollection::class,
            'service_name' => 'accounts',
        ],
        'api\\V1\\Rest\\TestSpecialEvents\\Controller' => [
            'listener' => \api\V1\Rest\TestSpecialEvents\TestSpecialEventsResource::class,
            'route_name' => 'api.rest.test-special-events',
            'route_identifier_name' => 'test_special_events_id',
            'collection_name' => 'test_special_events',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \api\V1\Rest\TestSpecialEvents\TestSpecialEventsEntity::class,
            'collection_class' => \api\V1\Rest\TestSpecialEvents\TestSpecialEventsCollection::class,
            'service_name' => 'TestSpecialEvents',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'api\\V1\\Rest\\Assignments\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Contacts\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Schedule_recipients\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Special_events\\Controller' => 'HalJson',
            'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Accounts\\Controller' => 'HalJson',
            'api\\V1\\Rest\\TestSpecialEvents\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'api\\V1\\Rest\\Assignments\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Contacts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Schedule_recipients\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Special_events\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Accounts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\TestSpecialEvents\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'api\\V1\\Rest\\Assignments\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Contacts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Schedule_recipients\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Special_events\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Accounts\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\TestSpecialEvents\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \api\V1\Rest\Assignments\AssignmentsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.assignments',
                'route_identifier_name' => 'assignments_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\Assignments\AssignmentsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.assignments',
                'route_identifier_name' => 'assignments_id',
                'is_collection' => true,
            ],
            \api\V1\Rest\Contacts\ContactsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.contacts',
                'route_identifier_name' => 'contacts_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\Contacts\ContactsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.contacts',
                'route_identifier_name' => 'contacts_id',
                'is_collection' => true,
            ],
            \api\V1\Rest\Schedule_recipients\Schedule_recipientsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.schedule_recipients',
                'route_identifier_name' => 'schedule_recipients_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\Schedule_recipients\Schedule_recipientsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.schedule_recipients',
                'route_identifier_name' => 'schedule_recipients_id',
                'is_collection' => true,
            ],
            \api\V1\Rest\Special_events\Special_eventsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.special_events',
                'route_identifier_name' => 'special_events_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\Special_events\Special_eventsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.special_events',
                'route_identifier_name' => 'special_events_id',
                'is_collection' => true,
            ],
            'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\TemplatesForIncompleteMonthsOfAssignmentsEntity' => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.templates-for-incomplete-months-of-assignments',
                'route_identifier_name' => 'templates_for_incomplete_months_of_assignments_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \api\V1\Rest\TemplatesForIncompleteMonthsOfAssignments\TemplatesForIncompleteMonthsOfAssignmentsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.templates-for-incomplete-months-of-assignments',
                'route_identifier_name' => 'templates_for_incomplete_months_of_assignments_id',
                'is_collection' => true,
            ],
            \api\V1\Rest\Accounts\AccountsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.accounts',
                'route_identifier_name' => 'accounts_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\Accounts\AccountsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.accounts',
                'route_identifier_name' => 'accounts_id',
                'is_collection' => true,
            ],
            \api\V1\Rest\TestSpecialEvents\TestSpecialEventsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.test-special-events',
                'route_identifier_name' => 'test_special_events_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \api\V1\Rest\TestSpecialEvents\TestSpecialEventsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.test-special-events',
                'route_identifier_name' => 'test_special_events_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'api\\V1\\Rest\\Assignments\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Assignments\\Validator',
        ],
        'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'api\\V1\\Rest\\Assignments\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'description' => 'Month and day of the month of the assignment.
Example: March 1',
                'field_type' => 'string',
                'error_message' => 'Please include the date of the assignment.
Example: March 1',
                'name' => 'date',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'assignment',
                'description' => 'Type of assignment.
Examples: Talk, Bible Reading',
                'field_type' => 'string',
                'error_message' => 'Please enter a valid assignment.',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'description' => 'Name of student.',
                'field_type' => 'string',
                'error_message' => 'Please enter the student\'s name.',
                'name' => 'name',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'assistant',
                'description' => 'Name of the assistant.
(optional)',
                'field_type' => 'string',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
        ],
        'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\Boolean::class,
                        'options' => [
                            'casting' => true,
                        ],
                    ],
                ],
                'name' => 'completelyUnassigned',
                'description' => 'Have no assignments been made for the month?',
                'field_type' => 'boolean',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'method',
                'description' => 'HTTP method used to create the entities.',
                'field_type' => 'string',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'api\\V1\\Rest\\Contacts\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'api\\V1\\Rest\\Schedule_recipients\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'api\\V1\\Rest\\Special_events\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
