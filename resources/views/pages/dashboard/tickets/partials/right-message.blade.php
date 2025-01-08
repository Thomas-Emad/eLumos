<div class="flex justify-end">
    <div class="bg-blue-700 p-3 rounded-lg max-w-sm text-white">
        {{ $message->message }}
        <span class="block text-xs text-end text-gray-200 italic">
            <i class="fa-regular fa-clock"></i>
            <span class="time_message"
                data-create="{{ $message->created_at }}">{{ $message->created_at->diffForHumans() }}</span>
        </span>
    </div>
</div>
