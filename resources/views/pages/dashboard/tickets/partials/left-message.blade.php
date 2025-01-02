<div class="flex justify-start">
    <div class="bg-gray-200 p-3 rounded-lg max-w-sm">
        {{ $message->message }}
        <span class="block text-xs text-end text-gray-700 italic">
            <i class="fa-regular fa-clock"></i>
            <span>{{ $message->created_at->diffForHumans() }}</span>
        </span>
    </div>
</div>
