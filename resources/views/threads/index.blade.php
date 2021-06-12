<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex py-4 space-x-6 border-b mb-6">
                <x-dropdown align="left" width="w-32">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center font-semibold text-gray-600 hover:text-gray-800 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">
                            <div>{{ __('Channels') }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                            @foreach ($channels as $channel)
                                <x-dropdown-link :href="'/threads/' .  $channel->slug" class="">
                                    {{ $channel->name }}
                                </x-dropdown-link>
                            @endforeach
                    </x-slot>
                </x-dropdown>

                @auth
                    <a href="/threads?by={{ auth()->user()->name }}" class="font-semibold block text-gray-600 hover:text-gray-800 transition duration-150 ease-in-out">My Threads</a>
                @endauth
            </div>

            <div>
                @foreach ($threads as $thread)
                    <div class="p-6 bg-white rounded-lg mb-7 shadow">
                        <h4 class="text-xl font-semibold">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
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
    </div>
</x-app-layout>