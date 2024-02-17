@php use App\Models\Member; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst(request()->query('status'))." Salary" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($status == Member::STATUS_PART_TIME)
                @include('salary.parttime_form')
            @elseif($status == Member::STATUS_PERMANENT)
                @include('salary.parmenant_form')
            @elseif($status == Member::STATUS_TRAINING)
                @include('salary.training_form')
            @else
                <p>Invalid member type.</p>
            @endif
        </div>
        <div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
