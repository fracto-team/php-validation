<?php

namespace Fracto\Validation\Exceptions;

use InvalidArgumentException;
use Throwable;

class RuleNotExistsException extends InvalidArgumentException
{
    public function __construct(string $key, Throwable $previous = null)
    {
        parent::__construct("Rule handler of `${key}` does not exists", 0, $previous);
    }
}