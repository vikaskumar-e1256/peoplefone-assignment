<ul id="notifications-list" class="mt-2 space-y-2">
    @foreach ($notifications as $notification)
        <li class="flex items-center justify-between p-2 border-b border-gray-200">
            <span
                class="cursor-pointer {{ !$notification->is_read ? 'text-gray-900 font-semibold' : 'text-gray-500' }}"
                data-id="{{ $notification->id }}">
                {{ $notification->text }}
            </span>
            @if ($notification->is_read)
                <span class="text-gray-500 text-sm">Read</span>
            @endif
        </li>
    @endforeach
</ul>
