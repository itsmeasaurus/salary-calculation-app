<?php

namespace App\Salary;

use App\Models\Salary;

class ParmenantSalaryCalculator implements SalaryCalculatorInterface
{
    public function calculate()
    {
        $basic_salary = request()->input('basic_salary');
        $overtime = request()->input('overtime');

        $salary_per_hour = Salary::salaryPerHour($basic_salary);
        $approximate_overtime = Salary::approximateHour($overtime);
        $overtime_salary = $overtime ? ($salary_per_hour * $approximate_overtime) : 0;

        return [
            'basic_salary' => $basic_salary,
            'per_hour' => $salary_per_hour,
            'working_hour' => Salary::getBaseWorkingHoursPerMonth() + $approximate_overtime,
            'overtime' => $approximate_overtime,
            'gross_salary' => $basic_salary + $overtime_salary,
            'message' => (new Salary)->parmenant_message
        ];
    }
}
