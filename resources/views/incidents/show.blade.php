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
                        @php use Illuminate\Support\Facades\Storage; @endphp
                        @if ($incident->files->isNotEmpty())
                            <div class="mt-4">
                                <h3 class="font-medium">{{ __('Files') }}</h3>
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($incident->files as $file)
                                        @php $ext = pathinfo($file->path, PATHINFO_EXTENSION); @endphp
                                        @if (in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                                            <img src="{{ Storage::url($file->path) }}" class="max-w-full h-auto" />
                                        @else
                                            <a href="{{ Storage::url($file->path) }}" class="text-blue-500 underline" target="_blank">{{ basename($file->path) }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
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
