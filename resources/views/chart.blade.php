<x-app-layout>
    <h1 class="text-4xl text-center mt-5 font-semibold">
        Chart
    </h1>
    <p class="text-center mt-3">
        Check last 7 days of USD exchange rate
    </p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            {{-- pages navigation --}}
            <x-currency-components.pages-navigation></x-currency-components.pages-navigation>

            <div class="w-full sm:flex sm:justify-evenly my-3 sm:space-x-1 items-center">
                <div class="font-bold text-3xl text-center">
                    1 USD
                </div>
                <div class="text-center">
                    <span class="material-icons text-4xl text-blue-600 rotate-90 sm:rotate-0 ">
                        arrow_right_alt
                    </span>
                </div>
                <x-currency-components.currency-dropbox :currencies="$currencies" destination='targetedCurrency' labelName='To'
                    :oldSelected="$targetedCurrency"></x-currency-components.currency-dropbox>
            </div>
            <div class="flex justify-center h-72 w-full">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        const dropDown = document.getElementById('targetedCurrency')

        async function chartDataReqeust(myChart) {
            const url = @json(route('chart.data'));
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    targetedCurrency: dropDown.value,
                }),
            })

            if (!response.ok) {
                console.log(response.status);
            } else {
                const result = await response.json();
                // console.log('API Response:', result);
                // console.log(result.data);
                myChart.data.datasets[0].data = result.data.map(rates => rates.rate);
                myChart.options.scales.y.title.text = result.targetedCurrency;
                myChart.update();

            }
        }

        const ctx = document.getElementById('myChart');

        const lastSevenDays = @json($lastSevenDays);
        document.addEventListener('DOMContentLoaded', function() {
            let lastSevenDaysName = @json($lastSevenDaysName);
            lastSevenDaysName.reverse()
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lastSevenDaysName,
                    datasets: [{
                        label: 'Rate of exchange',
                        data: lastSevenDays.map(rates => rates.rate),
                        borderWidth: 2,
                    }]
                },
                options: {
                    elements: {
                        line: {
                            // tension: 0.2,
                            fill: true,
                            cubicInterpolationMode: 'monotone',
                            // borderJoinStyle: 'round',
                        },
                    },
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: 'Thai Baht',
                            },
                            // display: false,
                            beginAtZero: false,
                            // min: 0, // Set the minimum value for the y-axis
                            // max: 60, // Set the maximum value for the y-axis
                            // ticks: {
                            //     stepSize: 0.02 // Set the step size between ticks on the y-axis
                            // }
                        }
                    },
                    //responsive: true, // Ensures the chart resizes with its container
                    maintainAspectRatio: false, // Optional: disable aspect ratio locking
                }
            });


            //fetching data for currency
            dropDown.addEventListener('change', function() {
                chartDataReqeust(myChart)
            });
        });
    </script>
</x-app-layout>
