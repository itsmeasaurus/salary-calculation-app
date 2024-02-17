<?php

namespace App\Providers;

use App\Salary\ParmenantSalaryCalculator;
use App\Salary\PartTimeSalaryCalculator;
use App\Salary\SalaryCalculatorInterface;
use App\Salary\TrainingSalaryCalculator;
use App\Validator\ParmenantSalaryValidator;
use App\Validator\PartTimeSalaryValidator;
use App\Validator\TrainingSalaryValidator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use mysql_xdevapi\Exception;

class SalaryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SalaryCalculatorInterface::class, function ($app) {

            $status = Request::query('status');

            $this->validateInput($this->getValidator($status));

            return $this->getCalculator($status);

        });
    }

    private function validateInput($validator)
    {
        if (!$validator->validate(request()->all())) {
            throw new Exception('Invalid input data');
        }
        return true;
    }

    private function getValidator($status)
    {
        return match ($status) {
            'training' => new TrainingSalaryValidator(),
            'part_time' => new PartTimeSalaryValidator(),
            'permanent' => new ParmenantSalaryValidator(),
            default => throw new \Exception('Invalid status provided'),
        };
    }

    private function getCalculator($status)
    {
        return match ($status) {
            'training' => new TrainingSalaryCalculator(),
            'part_time' => new PartTimeSalaryCalculator(),
            'permanent' => new ParmenantSalaryCalculator(),
            default => throw new \Exception('Invalid status provided'),
        };
    }

    public function boot()
    {
    }
}
