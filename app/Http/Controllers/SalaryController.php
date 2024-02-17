<?php

namespace App\Http\Controllers;

use App\Salary\SalaryCalculatorInterface;

class SalaryController extends Controller
{
    public function index()
    {
        return view('salary.index');
    }

    public function detail()
    {
        return view('salary.detail', [
            'status' => request()->query('status')
        ]);
    }

    public function calculate(SalaryCalculatorInterface $salaryCalculatorInterface)
    {
        return view('salary.result', $salaryCalculatorInterface->calculate());
    }
}
