# Fracto Simple PHP Validation Library

## How to use?

```php
<?php

use Fracto\Validation\Exceptions\ValidationException;
use Fracto\Validation\Validator;

require "vendor/autoload.php";

$rules = ['first_name' => 'required|min_length:12'];
$input = ['first_name' => '123'];

$validator = Validator::make($rules, $input);

try {
    $validator->validate();
} catch (ValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
}

```