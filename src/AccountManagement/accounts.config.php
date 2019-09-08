<?php

namespace StudentAssignmentScheduler\AccountManagement;

$service = [
    Services\AccountStoreServiceInterface::class => [
        "implementation" => Services\JsonDocumentStoreService::class,
        "dependencies" => [
            new AccountStoreReference(__DIR__ . "/data/accounts.json"),
            new AccountStoreReference(__DIR__ . "/data/revoked_accounts.json")
        ]
    ]
];

return [
    "store" => AccountStore::class,
    "dependencies" => [
        AccountStore::class => [
            Services\AccountStoreServiceInterface::class
        ]
    ],
    "service" => $service
];
