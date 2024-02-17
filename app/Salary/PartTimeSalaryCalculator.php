<?php

namespace App\Salary;

use App\Models\Salary;

class PartTimeSalaryCalculator implements SalaryCalculatorInterface
{

    public function calculate()
    {
        $basic_salary = request()->input('basic_salary');
        $working_hours = request()->input('working_hours');

        $salary_per_hour = Salary::salaryPerHour($basic_salary);
        $approximate_working_hours = Salary::approximateHour($working_hours);

        return [
            'basic_salary' => $basic_salary,
            'per_hour' => $salary_per_hour,
            'working_hour' => $approximate_working_hours,
            'overtime' => NULL,
            'gross_salary' => $salary_per_hour * $approximate_working_hours,
            'message' => (new Salary)->part_time_message
        ];
    }
}
