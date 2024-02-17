<?php

namespace App\Validator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartTimeSalaryValidator extends CommonSalaryValidator
{
    protected $partTimeRules = [
        'working_hours' => 'required|numeric|min:0',
    ];
    public function validate($data)
    {
        $rules = array_merge($this->partTimeRules, $this->sharedRules);

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        return true;
    }
}
