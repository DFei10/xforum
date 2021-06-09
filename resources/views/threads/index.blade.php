<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($threads as $thread)
                <div class="p-6 bg-white rounded-lg mb-7 shadow">
                    <h4 class="text-xl font-semibold">
                        <a href="/threads/{{ $thread->id }}">{{ $thread->title }}</a>
                    </h4>
                    <div class="flex py-6">
                        <div>
                            <img
                                src="https://pbs.twimg.com/profile_images/914894066072113152/pWD-GUwG_400x400.jpg"
                                alt="Author avatar"
                                class="w-10 rounded-full"
                            >
                        </div>
                        <div class="ml-5">
                            <h4>
                                <a href="#" class="block font-semibold text-sm">{{ $thread->author->name }}</a>
                                <span class="block text-xs text-gray-400">{{ $thread->created_at->diffForHumans() }}</span>
                            </h4>
                        </div>
                    </div>
                    <p class="mt-2">{{ $thread->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>