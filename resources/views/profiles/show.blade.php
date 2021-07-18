<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profiles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded mb-7 shadow flex justify-between">
                <h2 class="font-bold text-gray-700">{{ $user->name }}</h2>
                <span class="text-gray-400 text-xs">{{ $user->created_at->diffForHumans() }}</span>
            </div>

            <div class="mt-7 space-y-3">
                @foreach ($activities as $date => $activity)
                    <h2 class="text-gray-600 font-bold">{{ $date }}</h2>
                    @foreach ($activity as $record)
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>
