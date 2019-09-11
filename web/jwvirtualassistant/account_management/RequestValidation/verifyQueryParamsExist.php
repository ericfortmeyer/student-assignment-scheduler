<?php declare(strict_types=1);

namespace jwvirtualassistant\AccountManagement\RequestValidation;

use Psr\Http\Message\ServerRequestInterface;

function verifyQueryParamsExist(
    ServerRequestInterface $request,
    array $requiredParams,
    callable $doIfNotExist
): void {
    if (empty(
        array_intersect($request->getQueryParams(), $requiredParams)
    )) {
        $doIfNotExist();
    }
}
