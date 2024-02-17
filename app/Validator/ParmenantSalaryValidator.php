<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ParmenantSalaryValidator extends CommonSalaryValidator
{
    protected $parmenantRules = [
        'overtime' => 'nullable|numeric|min:0',
    ];

    public function validate($data)
    {
        $rules = array_merge($this->parmenantRules, $this->sharedRules);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
