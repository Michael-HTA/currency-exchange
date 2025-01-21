@php
    $countries = [
        'USD' => 'US Dollar',
        'EUR' => 'Euro',
        'GBP' => 'British Pound',
        'CAD' => 'Canadian Dollar',
        'AUD' => 'Australian Dollar',
    ];
@endphp

<x-app-layout>
    <h1 class="text-4xl text-center mt-10 font-semibold">
        Chart
    </h1>
    <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            <div class="flex justify-evenly border mt-5 rounded-3xl">
                <x-currency-components.currency-nav link="{{ route('home') }}" :isActive='false'
                    iconName='currency_exchange' name='Convert'></x-currency-components.currency-nav>
                <x-currency-components.currency-nav link="{{ route('chart') }}" :isActive='true' iconName='analytics'
                    name='Chart'></x-currency-components.currency-nav>
            </div>

            <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1 items-center">
                <x-currency-components.currency-dropbox :countries="$countries" destination='baseCurrency'
                        labelName='From' oldSelected={{ $baseCurrency }}></x-currency-components.currency-dropbox>
                <div class="w-auto flex justify-center">
                    <x-currency-components.swap-button from='baseCurrency'
                            to='targetedCurrency'></x-currency-components.swap-button>
                </div>
                <x-currency-components.currency-dropbox :countries="$countries" destination='targetedCurrency'
                        labelName='To' oldSelected={{ $targetedCurrency }}></x-currency-components.currency-dropbox>
            </div>
            <div class="flex justify-center h-72 w-full">
                <canvas id="myChart"></canvas>
            </div>
        </div>

    </div>
    <script>
        const ctx = document.getElementById('myChart');
        // console.log(Chart);
        document.addEventListener('DOMContentLoaded', function() {
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange','Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3,12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    //responsive: true, // Ensures the chart resizes with its container
                    maintainAspectRatio: false, // Optional: disable aspect ratio locking
                }
            });
        });
    </script>
</x-app-layout>
