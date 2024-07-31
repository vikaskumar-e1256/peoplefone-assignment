<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if (auth()->user()->is_admin)
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        {{ __('Users') }}
                    </x-nav-link>
                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                        {{ __('Notifications') }}
                    </x-nav-link>
                    <x-nav-link :href="route('notifications.create')" :active="request()->routeIs('notifications.create')">
                        {{ __('Create Notification') }}
                    </x-nav-link>
                    @endif
                    @impersonating($guard = null)
                        <x-nav-link :href="route('impersonate.leave')">{{ __('Leave impersonation') }}</x-nav-link>
                    @endImpersonating
                </div>
            </div>

            @if (!auth()->user()->is_admin)
            <div class="relative">
                <button id="notification-button" class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l1.405-1.405a2.25 2.25 0 00.345-2.71L20 13v-7a6 6 0 00-12 0v7l-1.75 1.75a2.25 2.25 0 00.345 2.71L5 17h5" />
                        <circle cx="17" cy="7" r="4" />
                    </svg>
                    <span id="notification-count" class="absolute top-0 right-0 block w-3 h-3 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">0</span>
                </button>

                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg hidden overflow-hidden">
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">Unread Notifications</h4>
                        <div class="max-h-60 overflow-y-auto"> <!-- Scrollable area -->
                            <ul id="notifications-list" class="mt-2 space-y-2">
                                <!-- Notifications will be loaded here via Ajax -->
                            </ul>
                        </div>
                        <div id="mark-all-read" class="mt-4">
                            <button id="mark-all-read-button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Mark All as Read
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if (auth()->user()->is_admin)
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                {{ __('Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('notifications.create')" :active="request()->routeIs('notifications.create')">
                {{ __('Create Notification') }}
            </x-responsive-nav-link>
            @endif

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


<script>
$(document).ready(function() {
    let notificationsOpen = false;

    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const ajaxSetup = () => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    };

    const fetchNotifications = () => {
        $.ajax({
            url: '{{ route("notifications.fetch") }}',
            method: 'GET',
            success: function(response) {
                $('#notifications-list').html(response.html);
                $('#notification-count').text(response.unreadCount);
                toggleMarkAllReadButton(response.unreadCount > 0);
            }
        });
    };

    const toggleMarkAllReadButton = (show) => {
        if (show) {
            $('#mark-all-read').removeClass('hidden');
        } else {
            $('#mark-all-read').addClass('hidden');
        }
    };

    $('#notification-button').click(function() {
        notificationsOpen = !notificationsOpen;
        $('#notifications-dropdown').toggle(notificationsOpen);
        if (notificationsOpen) {
            fetchNotifications();
        }
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('#notification-button, #notifications-dropdown').length) {
            if (notificationsOpen) {
                notificationsOpen = false;
                $('#notifications-dropdown').hide();
            }
        }
    });

    $(document).on('click', '#notifications-list span', function() {
        const notificationId = $(this).data('id');
        if ($(this).hasClass('text-gray-500')) return; // Skip if already read

        ajaxSetup();
        $.ajax({
            url: `{{ url("/notifications/mark-as-read/notifications") }}/${notificationId}`,
            method: 'PATCH',
            success: function() {
                fetchNotifications();
            }
        });
    });

    $('#mark-all-read-button').click(function(e) {
        e.preventDefault();
        ajaxSetup();
        $.ajax({
            url: '{{ route("notifications.markAllRead") }}',
            method: 'POST',
            success: function() {
                fetchNotifications();
            }
        });
    });
    fetchNotifications();
});

</script>
