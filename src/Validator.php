<?php

namespace Fracto\Validation;

use Fracto\Validation\Exceptions\RuleKeyAlreadyExistsException;
use Fracto\Validation\Exceptions\RuleNotExistsException;
use Fracto\Validation\Exceptions\ValidationException;
use Fracto\Validation\Rules\MinLengthRule;
use Fracto\Validation\Rules\RequiredRule;

final class Validator
{
    protected $rules;
    protected $fields;
    protected $errors = [];
    protected static $ruleHandlers = [
        'required' => [RequiredRule::class, 'validate'],
        'min_length' => [MinLengthRule::class, 'validate'],
    ];

    protected function __construct(array $rules, array $fields)
    {
        $this->rules = $rules;
        $this->fields = $fields;
    }

    public static function getRuleHandlers(): array
    {
        return Validator::$ruleHandlers;
    }

    public static function addRule(string $key, callable $rule)
    {
        if (key_exists($key, Validator::$ruleHandlers)) {
            throw new RuleKeyAlreadyExistsException($key);
        }
        Validator::$ruleHandlers[$key] = $rule;
    }

    public static function make($rules, $fields): Validator
    {
        return new Validator($rules, $fields);
    }

    /**
     * @return array
     * @throws RuleNotExistsException
     */
    public function getErrors(): array
    {
        $handlers = Validator::getRuleHandlers();
        foreach ($this->rules as $field_name => $rule_group) {
            $value = null;
            if (key_exists($field_name, $this->fields)) {
                $value = $this->fields[$field_name];
            }

            $rules = explode('|', $rule_group);

            foreach ($rules as $rule) {
                $name = $rule;
                $parameters = [];
                if (strpos($rule, ':')) {
                    [$name, $parameters_group] = explode(':', $rule);
                    $parameters = explode(",", $parameters_group);
                }
                if (!key_exists($name, $handlers)) {
                    throw new RuleNotExistsException($name);
                }

                if (!$handlers[$name]($this->fields, $field_name, $value, ...$parameters)) {
                    $this->errors[$field_name][] = ['rule_name' => $name, 'parameters' => $parameters];
                }
            }
        }

        return $this->errors;
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        $errors = $this->getErrors();
        if (count($this->errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
