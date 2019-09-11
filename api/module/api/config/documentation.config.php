<?php
return [
    'api\\V1\\Rest\\TemplatesForIncompleteMonthsOfAssignments\\Controller' => [
        'description' => 'Provides information about to help with creating forms for making assignments for a set of months.

The templates include pre-populated, required, and optional fields.  Each month will also contain a list of contacts/students for client validation when making assignments.  The templates will be for months that are either completely or partially unassigned.',
        'entity' => [
            'description' => 'Information that can be used when creating forms that will be used to make assignments.',
            'GET' => [
                'description' => 'Retrieve a c',
            ],
        ],
        'collection' => [
            'GET' => [
                'description' => 'Retrieve a collection of months of templates along with a collection of contacts.',
            ],
            'description' => 'A collection of months of templates along with a collection of contacts.',
        ],
    ],
];
