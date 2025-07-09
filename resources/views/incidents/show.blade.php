<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incident Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        {{ $incident->title }}
                    </h1>

                    <div class="mt-6 text-gray-500">
                        <p><strong>{{ __('Description') }}:</strong> {{ $incident->description }}</p>
                        <p><strong>{{ __('Location') }}:</strong> {{ $incident->location }}</p>
                        <p><strong>{{ __('Date') }}:</strong> {{ $incident->date }}</p>
                        <p><strong>{{ __('Officer') }}:</strong> {{ $incident->user->name }}</p>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('incidents.index') }}" class="text-sm text-gray-700 underline">
                            {{ __('Back to Incidents') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
