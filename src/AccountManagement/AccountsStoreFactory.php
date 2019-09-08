<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\AccountManagement;

final class AccountsStoreFactory
{
    public function getConfig(): array
    {
        return include __DIR__ . "/accounts.config.php";
    }

    public function __invoke(?string $store_type = null)
    {
        $config = $this->getConfig();
        $store_type_class_name = $store_type ?? $config["store"];{}
        if (key_exists($store_type_class_name, $config["dependencies"])) {
            $dependencies = array_map(
                function (string $class_name) use ($config): Services\AccountStoreServiceInterface {
                    $dependencies_of_service = $config["service"][$class_name]["dependencies"];
                    $implementation = $config["service"][$class_name]["implementation"];
                    return new $implementation(...$dependencies_of_service);
                },
                $config["dependencies"][$store_type_class_name]
            );
            return new $store_type_class_name(...$dependencies);
        } else {
            throw new \OutOfBoundsException("${store_type_class_name} does not exist or has not been configured");
        }
    }
}
