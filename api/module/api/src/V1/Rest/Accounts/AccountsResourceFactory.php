<?php
namespace api\V1\Rest\Accounts;

class AccountsResourceFactory
{
    public function __invoke($services)
    {
        return new AccountsResource();
    }
}
