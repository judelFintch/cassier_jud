<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incidents Map') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Set a default view
            const map = L.map('map').setView([48.8566, 2.3522], 12); // Centered on Paris

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            fetch('/api/incidents-map')
                .then(response => response.json())
                .then(data => {
                    data.forEach(incident => {
                        const marker = L.marker([incident.latitude, incident.longitude]).addTo(map);
                        marker.bindPopup(`<b>${incident.title}</b><br>${incident.location}`).openPopup();
                    });
                })
                .catch(error => console.error('Error fetching incidents:', error));
        });
    </script>
    @endpush
</x-app-layout>
