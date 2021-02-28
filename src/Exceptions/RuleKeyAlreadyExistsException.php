<?php

namespace Fracto\Validation\Exceptions;

use InvalidArgumentException;
use Throwable;

class RuleKeyAlreadyExistsException extends InvalidArgumentException
{
    public function __construct(string $key, Throwable $previous = null)
    {
        parent::__construct("Rule handler of `${key}` is already exists", 0, $previous);
    }
}