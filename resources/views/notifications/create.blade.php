<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('notifications.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
                                <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="">Select a type</option>
                                    <option value="marketing" {{ old('type') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="invoices" {{ old('type') == 'invoices' ? 'selected' : '' }}>Invoices</option>
                                    <option value="system" {{ old('type') == 'system' ? 'selected' : '' }}>System</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>

                            <!-- Text -->
                            <div>
                                <label for="text" class="block text-sm font-medium text-gray-700">{{ __('Text') }}</label>
                                <input type="text" name="text" id="text" value="{{ old('text') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <x-input-error class="mt-2" :messages="$errors->get('text')" />
                            </div>

                            <!-- Expiration -->
                            <div>
                                <label for="expiration" class="block text-sm font-medium text-gray-700">{{ __('Expiration') }}</label>
                                <input type="datetime-local" name="expiration" id="expiration" value="{{ old('expiration') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                <x-input-error class="mt-2" :messages="$errors->get('expiration')" />
                            </div>

                            <!-- User -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('User') }}</label>
                                <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
