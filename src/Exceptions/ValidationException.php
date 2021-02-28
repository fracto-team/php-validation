<?php

namespace Fracto\Validation\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected $errors;

    public function __construct(array $errors, Throwable $previous = null)
    {
        parent::__construct("Input data is not valid", 0, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}