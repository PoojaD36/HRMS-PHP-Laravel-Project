<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected function normalizeBooleanFields(
        array $fields
    ): void {

        $data = [];

        foreach ($fields as $field) {

            if ($this->has($field)) {

                $data[$field] = filter_var(
                    $this->$field,
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                );
            }
        }

        $this->merge($data);
    }
}