<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Salary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Part-time Salary
                    Calculation</h2>
                <p class="mt-4 mb-4 text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                </p>
                <a href="/salary/calculate?status=part_time" class="p-2 rounded bg-red-500">Calculate</a>
            </div>
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Permanent Salary
                    Calculation</h2>
                <p class="mt-4 mb-4 text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                </p>
                <a href="/salary/calculate?status=permanent" class="p-2 rounded bg-red-500">Calculate</a>
            </div>
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Training Salary Calculation</h2>
                <p class="mt-4 mb-4 text-gray-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, eaque esse hic neque quo ratione. At
                    dolor,
                    libero magni obcaecati rerum sunt voluptatem. Aspernatur dicta eum libero non quidem quisquam.
                </p>
                <a href="/salary/calculate?status=training" class="p-2 rounded bg-red-500">Calculate</a>
            </div>
        </div>
    </div>
</x-app-layout>
