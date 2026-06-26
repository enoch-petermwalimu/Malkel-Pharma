<?php

namespace App\Core;

class Validator
{
    protected array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {

            foreach ($fieldRules as $rule) {

                if ($rule === 'required') {

                    if (
                        !isset($data[$field]) ||
                        trim($data[$field]) === ''
                    ) {
                        $this->errors[$field][] =
                            "The {$field} field is required.";
                    }
                }

                if ($rule === 'email') {

                    if (
                        isset($data[$field]) &&
                        !filter_var($data[$field], FILTER_VALIDATE_EMAIL)
                    ) {
                        $this->errors[$field][] =
                            "Invalid email format.";
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}