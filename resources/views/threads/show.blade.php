<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Threads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <h2 class="text-xl font-bold mb-7 text-gray-800">{{ $thread->replies_count }} {{ \Str::plural('Reply', $thread->replies_count) }}</h2>

            <div class="space-y-4">
                @foreach ($replies as $reply)
                    <div class="p-6 bg-white rounded-lg shadow">
                        <p>{{ $reply->body }}</p>
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
                            <textarea
                                name="body"
                                id="body"
                                class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Have something to say?"
                                rows="3"
                            ></textarea>
                        </div>

                        <x-button class="mt-3">Post</x-button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}" class="cursor-pointer text-blue-600 hover:underline">sign in</a> to participate in this thread.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>