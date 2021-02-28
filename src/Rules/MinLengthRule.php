<?php

namespace Fracto\Validation\Rules;

use Fracto\Validation\Contracts\RuleContract;

final class MinLengthRule implements RuleContract
{

    static function validate($fields, $property, $value, ...$parameters): bool
    {
        if (empty($value)) return true;

        $length = intval($parameters[0]);

        return $length <= strlen($value);
    }
}