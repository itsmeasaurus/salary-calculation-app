<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-member-filter-buttons></x-member-filter-buttons>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul role="list" class="divide-y divide-gray-100 space-y-6">
                        @forelse($members as $member)
                        <a href="/member/{{ $member->status }}/{{ $member->name_slug }}" class="flex justify-between gap-x-6 py-5">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ strtoupper($member->name) }}</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                        {{ $member->email }}</p>
                                </div>
                            </div>
                            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end flex-col">
                                <p class="text-sm leading-6 text-gray-900">{{ $member->position }}</p>
                                <p class="text-xs leading-5 text-gray-500 flex justify-end">
                                    {{ strtoupper($member->status) }}
                                </p>
                            </div>
                        </a>
                        @empty
                            <p>There is no member yet.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
