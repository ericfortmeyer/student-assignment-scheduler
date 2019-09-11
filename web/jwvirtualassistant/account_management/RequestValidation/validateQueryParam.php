<?php declare(strict_types=1);

namespace jwvirtualassistant\AccountManagement\RequestValidation;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Validate the request.
 */
function validateQueryParam(
    ServerRequestInterface $request,
    array $query_param_keys,
    \Closure $validateQueryParamFunc,
    callable $doIfNotValid
): void {
    $query_params = array_map(
        function (string $key) use ($request): string {
            return $request->getQueryParams()[$key];
        },
        $query_param_keys
    );
    ! $validateQueryParamFunc(...$query_params) && $doIfNotValid();
}
