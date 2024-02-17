<form action="/salary/calculate/?status={{ request()->query('status') }}" class="space-y-6" method="POST">
    @csrf
    <div>
        <label for="basic_salary" class="block text-sm font-medium leading-6 text-gray-900">Basic Salary</label>
        <div class="relative mt-2 rounded-md">
            <input
                type="number"
                name="basic_salary"
                id="basic_salary"
                class="block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                placeholder="150,000">
        </div>
    </div>
    <div>
        <label for="working_days" class="block text-sm font-medium leading-6 text-gray-900">Overtime Hours</label>
        <div class="relative mt-2 rounded-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="text-gray-500 sm:text-sm"></span>
            </div>
            <input
                type="text"
                name="overtime"
                id="overtime"
                class="block rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                placeholder="160 Hrs">
        </div>
    </div>
    <div>
        <button type="submit" class="bg-red-500 p-4 rounded text-white">Calculate</button>
    </div>
</form>
