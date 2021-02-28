<?php

namespace Fracto\Validation\Rules;

use Fracto\Validation\Contracts\RuleContract;

final class RequiredRule implements RuleContract
{
    public static function validate($fields, $property, $value, ...$parameters): bool
    {
        return !empty($value);
    }
}