<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Incident') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('incidents.update', $incident->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $incident->title }}" />
                            </div>
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-textarea rounded-md shadow-sm mt-1 block w-full">{{ $incident->description }}</textarea>
                            </div>
                            <div>
                                <label for="location" class="block font-medium text-sm text-gray-700">{{ __('Location') }}</label>
                                <div class="flex">
                                    <input type="text" name="location" id="location" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $incident->location }}" />
                                    <button id="geocode-btn" class="ml-2 mt-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                            <div id="map" class="h-64 w-full"></div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ $incident->latitude }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $incident->longitude }}">
                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">{{ __('Date') }}</label>
                                <input type="datetime-local" name="date" id="date" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ \Carbon\Carbon::parse($incident->date)->format('Y-m-d\TH:i') }}" />
                            </div>
                            <div>
                                <label for="user_id" class="block font-medium text-sm text-gray-700">{{ __('Officer') }}</label>
                                <select name="user_id" id="user_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id == $incident->user_id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const defaultLat = {{ $incident->latitude ?? '48.8566' }};
        const defaultLng = {{ $incident->longitude ?? '2.3522' }};
        const map = L.map('map').setView([defaultLat, defaultLng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker;
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        function setMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            latInput.value = lat;
            lngInput.value = lng;
        }

        if (latInput.value && lngInput.value) {
            setMarker(latInput.value, lngInput.value);
        }

        map.on('click', function (e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        document.getElementById('geocode-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const address = document.getElementById('location').value;
            if (!address) return;
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        map.setView([lat, lng], 13);
                        setMarker(lat, lng);
                    }
                });
        });
    });
</script>
@endpush
