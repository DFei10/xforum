<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Thread') }}
        </h2>
    </x-slot>

    <div class="max-w-lg bg-white mx-auto mt-10 py-4 px-6 shadow rounded-lg">
        <form action="/threads" method="POST">
            @csrf

            <div class="space-y-3">
                <div>
                    <x-label for="title" :value="__('Title')" />
                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                </div>

                <div>
                    <x-label for="body" :value="__('Body')" />
                    <x-textarea id="body" name="body" class="block mt-1 w-full" rows="5"></x-textarea>
                </div>

                <x-button>Publish</x-button>
            </div>
        </form>
    </div>
</x-app-layout>
