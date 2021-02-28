<?php

namespace Fracto\Validation\Contracts;

interface RuleContract
{
    static function validate($fields, $property, $value, ...$parameters): bool;
}