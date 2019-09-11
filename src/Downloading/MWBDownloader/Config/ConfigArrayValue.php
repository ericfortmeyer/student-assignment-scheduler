<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Downloading\MWBDownloader\Config;

class ConfigArrayValue implements \ArrayAccess
{
    protected const REQUIRED_KEYS = [];

    private $path_to_config_file = "";

    protected $container;

    public function __construct(array $given_array, string $path_to_config_file = "")
    {
        $this->path_to_config_file = $path_to_config_file;

        $this->completeConstuctionOnlyIfConfigHasExpectedKeys($given_array);
    }

    private function completeConstuctionOnlyIfConfigHasExpectedKeys(array $given_array)
    {
        $this->validateQueryParams($given_array) && $this->container = $given_array;
    }
    
    /**
     * Validate that the query params specified in the configuration
     * contains expected keys.
     * @throws InvalidConfigurationException
     * @param array $given_array
     * @return bool
     */
    private function validateQueryParams(array $given_array): bool
    {
        $keys = array_keys($given_array);
        $required_keys = static::REQUIRED_KEYS;
        
        sort($required_keys);
        sort($keys);


        if ($required_keys != $keys) {
            throw new InvalidConfigurationException(
                "The given array does not contain expected keys."
                    . PHP_EOL . "Given array: " . json_encode(array_keys($given_array))
                    . PHP_EOL . "Expected keys: " . json_encode(static::REQUIRED_KEYS)
                    . PHP_EOL . "Check configuration in {$this->path_to_config_file}"
            );
        } else {
            return true;
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->container);
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset];
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetSet($offset, $value): void
    {
        $this->container[$offset] = $value;
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    public function toArray(): array
    {
        return $this->container;
    }
}
