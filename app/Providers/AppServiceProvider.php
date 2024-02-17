<?php

namespace App\Providers;

use App\Salary\ParmenantSalaryCalculator;
use App\Salary\PartTimeSalaryCalculator;
use App\Salary\SalaryCalculatorInterface;
use App\Salary\TrainingSalaryCalculator;
use App\Validator\ParmenantSalaryValidator;
use App\Validator\PartTimeSalaryValidator;
use App\Validator\TrainingSalaryValidator;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use mysql_xdevapi\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
