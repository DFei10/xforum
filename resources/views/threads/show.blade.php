<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg mb-7 shadow">
                <div class="flex justify-between">
                    <h4 class="text-xl font-semibold">
                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                    </h4>

                    <x-dropdown>
                        <x-slot name="trigger">
                            <button
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                    </path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @can('update', $thread)
                                <form method="POST" action="{{ $thread->path() }}">
                                    @csrf
                                    @method('DELETE')

                                    <x-dropdown-link :href="$thread->path()" onclick="event.preventDefault();
                                                            this.closest('form').submit();" class="text-sm">
                                        {{ __('Delete thread') }}
                                    </x-dropdown-link>
                                </form>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="flex py-6">
                    <div>
                        <img src="https://pbs.twimg.com/profile_images/914894066072113152/pWD-GUwG_400x400.jpg"
                            alt="Author avatar" class="w-10 rounded-full">
                    </div>
                    <div class="ml-5">
                        <h4>
                            <a href="#" class="block font-semibold text-sm">{{ $thread->author->name }}</a>
                            <span
                                class="block text-xs text-gray-400">{{ $thread->created_at->diffForHumans() }}</span>
                        </h4>
                    </div>
                </div>
                <p class="mt-2">{{ $thread->body }}</p>
            </div>

            <h2 class="text-xl font-bold mb-7 text-gray-800">{{ $thread->replies_count }}
                {{ \Str::plural('Reply', $thread->replies_count) }}</h2>


            <div class="space-y-4">
                @foreach ($replies as $reply)
                    <div class="px-6 pt-6 pb-2 bg-white rounded-lg shadow">
                        <div class="flex">
                            <div class="mr-7 w-10">
                                <img src="https://pbs.twimg.com/profile_images/914894066072113152/pWD-GUwG_400x400.jpg"
                                    alt="Author avatar" class="rounded-full">
                            </div>
                            <div class="w-full">
                                <div class="text-sm text-gray-400 mb-2 flex justify-between">
                                    <div>
                                        <h4>
                                            <a href="#" class="font-bold text-gray-700">{{ $reply->owner->name }}</a>
                                            replied
                                        </h4>
                                        <span class="text-xs block">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div>
                                        <form action="/replies/{{ $reply->id }}/favorite" method="POST">
                                            @csrf
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p>{{ $reply->body }}</p>
                                <div class="border-t border-gray-100 mt-4">
                                    <form action="/replies/{{ $reply->id }}/favorite" method="POST" class="pt-1">
                                        @csrf
                                        <button {{ $reply->isFavorited() ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="align-text-top inline-block h-5 w-5 text-gray-700 hover:text-indigo-700 transition duration-200 {{ $reply->isFavorited() ? 'text-indigo-700' : '' }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                        <span
                                            class="text-gray-700 text-sm ml-2 py-1 inline-block">{{ $reply->favorites_count }}</span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $replies->links() }}
            </div>
            <div class="mt-10">
                @auth
                    <form action="{{ $thread->path() }}/replies" method="POST">
                        @csrf

                        <div>
                            <label for="body" class="text-sm uppercase font-bold text-gray-700">Leave a Reply</label>
                            <textarea name="body" id="body"
                                class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Have something to say?" rows="3"></textarea>
                        </div>

                        <x-button class="mt-3">Post</x-button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}" class="cursor-pointer text-blue-600 hover:underline">sign
                            in</a> to participate in this thread.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
