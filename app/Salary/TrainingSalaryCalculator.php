<?php

namespace App\Salary;

use App\Models\Salary;

class TrainingSalaryCalculator implements SalaryCalculatorInterface
{
    public function calculate()
    {
        $basic_salary = request()->input('basic_salary');
        $working_days = request()->input('working_days');

        return [
            'basic_salary' => $basic_salary,
            'per_hour' => NULL,
            'working_hour' => $working_days * 8,
            'overtime' => NULL,
            'gross_salary' => $basic_salary,
            'message' => (new Salary)->training_message
        ];
    }
}
