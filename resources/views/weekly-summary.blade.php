@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Weekly Mood Summary</h2>
        </div>
        <div class="card-body">
            <canvas id="weeklyMoodChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyMoodChart').getContext('2d');
            const moodData = @json($weeklyMoods);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(moodData),
                    datasets: [{
                            label: 'Happy',
                            data: Object.values(moodData).map(day => day.happy || 0),
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Neutral',
                            data: Object.values(moodData).map(day => day.neutral || 0),
                            backgroundColor: 'rgba(255, 206, 86, 0.5)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Sad',
                            data: Object.values(moodData).map(day => day.sad || 0),
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Mood Distribution Over the Week'
                        }
                    }
                }
            });
        });
    </script>
@endsection
