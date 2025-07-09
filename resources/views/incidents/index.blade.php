<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incidents') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-medium text-gray-900">
                            {{ __('Incidents') }}
                        </h1>
                        <a href="{{ route('incidents.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create Incident') }}
                        </a>
                    </div>

                    <form method="GET" action="{{ route('incidents.index') }}" class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                                <input type="date" name="date" id="date" value="{{ request('date') }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">{{ __('Location') }}</label>
                                <input type="text" name="location" id="location" value="{{ request('location') }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('Officer') }}</label>
                                <select name="user_id" id="user_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">{{ __('All') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                                <input type="text" name="category" id="category" value="{{ request('category') }}" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-gray-500">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('Title') }}</th>
                                    <th class="px-4 py-2">{{ __('Description') }}</th>
                                    <th class="px-4 py-2">{{ __('Location') }}</th>
                                    <th class="px-4 py-2">{{ __('Date') }}</th>
                                    <th class="px-4 py-2">{{ __('Officer') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incidents as $incident)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $incident->title }}</td>
                                        <td class="border px-4 py-2">{{ $incident->description }}</td>
                                        <td class="border px-4 py-2">{{ $incident->location }}</td>
                                        <td class="border px-4 py-2">{{ $incident->date }}</td>
                                        <td class="border px-4 py-2">{{ $incident->user->name }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('incidents.show', $incident->id) }}" class="text-blue-600 hover:text-blue-900">{{ __('View') }}</a>
                                            <a href="{{ route('incidents.edit', $incident->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                            <form action="{{ route('incidents.destroy', $incident->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $incidents->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
