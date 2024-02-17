<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    private static $training_salary = 20000;
    private static $training_days = 10;
    private static $base_working_hours_per_day = 8;
    private static $base_working_hours_per_month = 160;
    private static $base_working_days = 20;

    // This will be working with backend or database in the future
    public $part_time_message = "For the part-time members, there is no overtime and salary will be calculated based on their perhour salary and working hours.";
    public $training_message = "For the training members, the salary will be fixed price and the member should work at least 10 days";
    public $parmenant_message = "For the parmenant members, there is no hour based calculation except for the overtimes";

    public static function salaryPerHour($basic_salary): float|int
    {
        return (($basic_salary / self::$base_working_days) / self::$base_working_hours_per_day);
    }

    public static function approximateHour($hours)
    {
        $hour = (int)$hours;

        if (str_contains($hours, '.')) {
            $minute = intval(($hours - $hour) * 60);
            $hour = ($minute >= 30) ? $hour + 1 : $hour;
        }

        return $hour;
    }

    public static function getBaseWorkingHoursPerMonth(): int
    {
        return self::$base_working_hours_per_month;
    }

    public static function getTrainingSalary(): float
    {
        return self::$training_salary;
    }

    public static function getTrainingDays(): int
    {
        return self::$training_days;
    }
}
