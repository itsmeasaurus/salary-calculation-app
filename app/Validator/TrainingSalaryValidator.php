<?php

namespace App\Validator;

use App\Models\Salary;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TrainingSalaryValidator extends CommonSalaryValidator
{
    protected $trainingRules = [
        'working_days' => 'required|numeric'
    ];

    public function validate($data)
    {
        $this->sharedRules['basic_salary'] = "required|numeric|size:" . Salary::getTrainingSalary();
        $this->sharedRules['working_days'] = "required|numeric|size:" . Salary::getTrainingDays();
        $rules = array_merge($this->trainingRules, $this->sharedRules);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
