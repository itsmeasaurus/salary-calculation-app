<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CommonSalaryValidator
{
    protected $sharedRules = [
        "basic_salary" => "required|numeric|integer|min:0",
    ];

    public function validate($data)
    {
        $validator = Validator::make($data, $this->sharedRules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
