<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Incident') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full"></textarea>
                            </div>
                            <div>
                                <label for="location" class="block font-medium text-sm text-gray-700">{{ __('Location') }}</label>
                                <input type="text" name="location" id="location" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">{{ __('Date') }}</label>
                                <input type="datetime-local" name="date" id="date" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div>
                                <label for="user_id" class="block font-medium text-sm text-gray-700">{{ __('Officer') }}</label>
                                <select name="user_id" id="user_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="files" class="block font-medium text-sm text-gray-700">{{ __('Files') }}</label>
                                <input type="file" name="files[]" id="files" multiple class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
