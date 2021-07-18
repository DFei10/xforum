<x-activity>
    <x-slot name="heading">
        <img src="https://pbs.twimg.com/profile_images/914894066072113152/pWD-GUwG_400x400.jpg" alt="Author avatar" class="w-7 rounded-full">
        <div class="text-gray-700 ml-3">
            <a class="font-bold" href="#">{{ $user->name }}</a>
            published a <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
        </div>
    </x-slot>

    <x-slot name="body">
        <p>{{ $activity->subject->body }}</p>
    </x-slot>
</x-activity>