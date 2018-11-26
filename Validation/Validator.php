<?php

namespace TalkSlipSender\Validation;

class Validator
{
    private static $file_failure_patterns = [
        "has_previous_directory_shortcut" => "/(\.\.\/)+/",
        "has_php_tag" => "/(<\?php)+/",
        "has_php_stream_wrapper" => "/(php:\/\/)+/"
    ];

    public static function validateFile(string $file_contents)
    {
        return self::validate($file_contents, self::$file_failure_patterns);
    }

    private static function validate(string $value, array $failure_patterns)
    {
        return self::failCase($value, $failure_patterns)
            ? false
            : $value;
    }

    private static function failCase(string $value, array $failure_patterns): bool
    {
        $map = new \Ds\Map($failure_patterns);

        return $map->reduce(function ($carry, $description, $pattern) use ($value) {
            return $carry || preg_match($pattern, $value);
        });        
    }

    private static function fileFailCase(string $file): int
    {
        $map = new \Ds\Map(self::$file_failure_patterns);

        return $map->reduce(function ($carry, $key, $value) use ($file) {
            return $carry || preg_match($value, $file);
        });        
    }
}
