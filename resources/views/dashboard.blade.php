<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chart 1: Incidents by Type -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Incidents by Type</h3>
                        <canvas id="incidentsByTypeChart" class="mt-4"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Incidents by Day -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Incidents Over Last 30 Days</h3>
                        <canvas id="incidentsByDayChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart 1: Incidents by Type (Pie Chart)
            fetch('/api/stats/incidents-by-type')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('incidentsByTypeChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Incidents',
                                data: data.data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)',
                                    'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)',
                                    'rgba(153, 102, 255, 0.7)',
                                    'rgba(255, 159, 64, 0.7)'
                                ],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false
                                }
                            }
                        }
                    });
                });

            // Chart 2: Incidents by Day (Bar Chart)
            fetch('/api/stats/incidents-by-day')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('incidentsByDayChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Incidents per Day',
                                data: data.data,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            }
                        }
                    });
                });
        });
    </script>
    @endpush
</x-app-layout>
