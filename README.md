# Salary Calculation App

A Laravel application that demonstrates **OOP polymorphism** in practice — using interfaces, inheritance, and Laravel's service container to build a flexible salary calculation system where new employee types can be added without modifying existing code.

## Why Polymorphism?

In a naively written salary calculator, you'd end up with something like this:

```php
// Without polymorphism — a growing if/else chain
if ($status === 'permanent') {
    $salary = $basic + ($perHour * $overtime);
} elseif ($status === 'part_time') {
    $salary = $perHour * $workingHours;
} elseif ($status === 'training') {
    $salary = $fixedAmount;
}
// Every new employee type means touching this code again.
```

This violates the **Open/Closed Principle** — the code is open to modification every time a new status is introduced, and every change risks breaking existing logic.

With polymorphism, each employee type owns its own calculation logic behind a shared interface. The controller doesn't know (or care) which implementation it receives:

```php
// With polymorphism — the controller stays untouched forever
public function calculate(SalaryCalculatorInterface $calculator)
{
    return view('salary.result', $calculator->calculate());
}
```

Adding a new employee type? Create a new class, register it in the service provider, done. **Zero changes to existing code.**

## Architecture

The app applies polymorphism in two distinct layers — **calculation** (interface polymorphism) and **validation** (inheritance polymorphism) — wired together through Laravel's service container.

### High-Level Flow

```
  HTTP Request (POST /salary/calculate?status=permanent)
        │
        ▼
┌──────────────────────────────────┐
│      SalaryServiceProvider       │
│  ┌────────────────────────────┐  │
│  │ 1. Read ?status from query │  │
│  │ 2. Resolve validator       │──┼──▶ match($status) → Validator subclass
│  │ 3. Validate input          │  │
│  │ 4. Resolve calculator      │──┼──▶ match($status) → Calculator implementation
│  └────────────────────────────┘  │
└──────────────────────────────────┘
        │
        ▼
┌──────────────────────────────────┐
│       SalaryController           │
│                                  │
│  calculate(SalaryCalculatorInterface $calc)
│       └─▶ $calc->calculate()     │
│           (concrete type unknown) │
└──────────────────────────────────┘
        │
        ▼
      Response
```

### Pattern 1 — Interface Polymorphism (Salary Calculators)

A single interface, three interchangeable implementations. The controller depends only on the interface:

```
         ┌─────────────────────────────────┐
         │   SalaryCalculatorInterface     │
         │   + calculate(): array          │
         └────────┬────────┬───────────────┘
                  │        │          │
      ┌───────────┘        │          └────────────┐
      ▼                    ▼                       ▼
┌───────────────┐  ┌────────────────┐  ┌─────────────────────┐
│  Permanent    │  │   PartTime     │  │     Training        │
│  Salary       │  │   Salary       │  │     Salary          │
│  Calculator   │  │   Calculator   │  │     Calculator      │
├───────────────┤  ├────────────────┤  ├─────────────────────┤
│ basic_salary  │  │ basic_salary   │  │ basic_salary        │
│ + overtime    │  │ × working_hrs  │  │ (fixed amount,      │
│   pay         │  │   × per_hour   │  │  fixed days)        │
└───────────────┘  └────────────────┘  └─────────────────────┘
```

**Interface** — `app/Salary/SalaryCalculatorInterface.php`
```php
interface SalaryCalculatorInterface
{
    public function calculate();
}
```

**One of three implementations** — `app/Salary/ParmenantSalaryCalculator.php`
```php
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
            'basic_salary'  => $basic_salary,
            'per_hour'      => $salary_per_hour,
            'working_hour'  => Salary::getBaseWorkingHoursPerMonth() + $approximate_overtime,
            'overtime'      => $approximate_overtime,
            'gross_salary'  => $basic_salary + $overtime_salary,
            'message'       => (new Salary)->parmenant_message,
        ];
    }
}
```

### Pattern 2 — Inheritance Polymorphism (Validators)

A base validator defines shared rules; each subclass extends and overrides `validate()` with status-specific rules:

```
            ┌──────────────────────────┐
            │   CommonSalaryValidator  │
            │   # sharedRules[]        │
            │   + validate($data)      │
            └────────┬─────────────────┘
                     │
       ┌─────────────┼──────────────┐
       ▼             ▼              ▼
┌─────────────┐ ┌──────────┐ ┌────────────┐
│  Permanent  │ │ PartTime │ │  Training  │
│  Validator  │ │ Validator│ │  Validator │
├─────────────┤ ├──────────┤ ├────────────┤
│ + overtime  │ │ + working│ │ fixed      │
│   rules     │ │   _hours │ │ salary &   │
│             │ │   rules  │ │ days check │
└─────────────┘ └──────────┘ └────────────┘
```

Each child class merges its own rules with the parent's `$sharedRules` and overrides `validate()`:

```php
class PartTimeSalaryValidator extends CommonSalaryValidator
{
    protected $partTimeRules = [
        'working_hours' => 'required|numeric|min:0',
    ];

    public function validate($data)
    {
        $rules = array_merge($this->partTimeRules, $this->sharedRules);
        // validate with merged rules...
    }
}
```

### Pattern 3 — Repository Pattern

Member data access is abstracted behind an interface, making it easy to swap implementations (e.g., for testing):

```
  MemberRepositoryInterface
  ─────────────────────────
  + all()
  + findBySlug($slug)           ◀── MemberController depends on this
  + findByMultiple(array)
          │
          ▼
  MemberRepository (Eloquent)   ◀── Bound in RepositoryServiceProvider
```

### The Glue — Service Providers

`SalaryServiceProvider` is where the polymorphic resolution happens. It reads the `?status` query parameter and returns the correct calculator at runtime:

```php
// app/Providers/SalaryServiceProvider.php

$this->app->bind(SalaryCalculatorInterface::class, function ($app) {
    $status = Request::query('status');

    $this->validateInput($this->getValidator($status));

    return $this->getCalculator($status);  // Returns the right implementation
});

private function getCalculator($status)
{
    return match ($status) {
        'training'  => new TrainingSalaryCalculator(),
        'part_time' => new PartTimeSalaryCalculator(),
        'permanent' => new ParmenantSalaryCalculator(),
        default     => throw new \Exception('Invalid status provided'),
    };
}
```

## Project Structure

```
app/
├── Http/Controllers/
│   ├── MemberController.php          # Depends on MemberRepositoryInterface
│   └── SalaryController.php          # Depends on SalaryCalculatorInterface
│
├── Salary/
│   ├── SalaryCalculatorInterface.php # Contract for all calculators
│   ├── ParmenantSalaryCalculator.php # Permanent employee logic
│   ├── PartTimeSalaryCalculator.php  # Part-time employee logic
│   └── TrainingSalaryCalculator.php  # Training employee logic
│
├── Validator/
│   ├── CommonSalaryValidator.php     # Base validator with shared rules
│   ├── ParmenantSalaryValidator.php  # Extends base, adds overtime rules
│   ├── PartTimeSalaryValidator.php   # Extends base, adds working_hours rules
│   └── TrainingSalaryValidator.php   # Extends base, enforces fixed values
│
├── Repositories/
│   ├── MemberRepositoryInterface.php # Contract for member data access
│   └── MemberRepository.php          # Eloquent implementation
│
├── Models/
│   ├── Member.php                    # Employee model (leader/permanent/part_time/training)
│   ├── Salary.php                    # Salary utility constants and helpers
│   └── User.php                      # Auth user model
│
└── Providers/
    ├── SalaryServiceProvider.php     # Binds interface → implementation by status
    └── RepositoryServiceProvider.php # Binds repository interface → Eloquent impl
```

## Getting Started

```bash
# Clone the repository
git clone git@github.com:itsmeasaurus/salary-calculation-app.git
cd salary-calculation-app

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Run the app
php artisan serve
```

## Contact

For questions or suggestions, reach out at htetwaiyanaung.acc2@gmail.com.
