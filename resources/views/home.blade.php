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

    {{-- Header --}}
    <h1 class="text-4xl text-center mt-10 font-semibold">
        Currency Converter
    </h1>
    <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p>



    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            {{-- Navigation --}}
            <div class="flex justify-evenly border mt-5 rounded-3xl">
                <x-currency-components.currency-nav link="{{ route('home') }}" :isActive='true'
                    iconName='currency_exchange' name='Convert'></x-currency-components.currency-nav>
                <x-currency-components.currency-nav link="{{ route('chart') }}" :isActive='false' iconName='analytics'
                    name='Chart'></x-currency-components.currency-nav>
            </div>

            {{-- convert area --}}
            <form action="" method="GET" class="w-full">
                <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1 items-center">
                    <div
                        class="mt-1 sm:mt-0 border rounded-lg  p-3 w-full sm:w-1/3 focus-within:ring-1 focus-within:ring-sky-500 group hover:bg-slate-100">
                        <label for="amount" class="block text-gray-500">Amount</label>
                        <div class="flex ">
                            <span class="my-auto">$</span>
                            <input value="{{ isset($amount) ? $amount : '' }}" name="amount" min='0' max="1000000"
                                inputmode="numeric" type="number" id='amount'
                                class=" m-0 p-0 border-0 w-full  focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none group-hover:bg-slate-100">
                        </div>
                    </div>
                    <x-currency-components.currency-dropbox :countries="$countries" destination='baseCurrency'
                        labelName='From' oldSelected={{$baseCurrency}}></x-currency-components.currency-dropbox>
                    <div class="w-auto flex justify-center">
                        <x-currency-components.swap-button from='baseCurrency'
                            to='targetedCurrency'></x-currency-components.swap-button>
                    </div>
                    <x-currency-components.currency-dropbox :countries="$countries" destination='targetedCurrency'
                        labelName='To' oldSelected={{$targetedCurrency}}></x-currency-components.currency-dropbox>
                </div>


                {{-- result --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center">
                    <div class="flex rounded-xl p-3">
                        <div>
                            <p id='converted-result'>
                                {{ $amount . ' ' . $countries[$baseCurrency] }} =
                                {{ $amount * $exchangeRate . ' ' . $countries[$targetedCurrency] }}
                            </p>
                            <p>
                                1 {{ $baseCurrency }} = {{ $exchangeRate . ' ' . $targetedCurrency }}
                            </p>
                            <p>
                                1 {{ $targetedCurrency }} = {{ $reverseExchangeRate . ' ' . $baseCurrency }}
                            </p>
                        </div>

                        {{-- for authenticated user --}}
                        @auth
                            <div class="flex items-center justify-center mt-2">
                                <button type="button" class="hover:text-blue-500" onclick="bookmark(event)">
                                    <span class="material-icons block">
                                        star
                                    </span>
                                    <p>
                                        Bookmark!
                                    </p>
                                </button>
                            </div >
                        @endauth
                    </div>

                    {{-- convert button --}}
                    <div>
                        <button
                            class="w-36 bg-blue-600 text-center p-3 my-1 font-semibold text-white rounded-3xl hover:bg-blue-500 transition ease-in-out duration-300">
                            Convert
                        </button>
                    </div>
                </div>
            </form>


        </div>

        {{-- Table --}}
        <div class="sm:flex sm:justify-between sm:space-x-10">
            <x-currency-components.country-to-country-table from={{$countries[$baseCurrency]}}
                fromSymbol={{$baseCurrency}} to={{$countries[$targetedCurrency]}}
                toSymbol={{$targetedCurrency}}
                toValue={{$exchangeRate}}></x-currency-components.country-to-country-table>
            <x-currency-components.country-to-country-table from={{$countries[$targetedCurrency]}}
                fromSymbol={{$targetedCurrency}} to={{$countries[$baseCurrency]}} toSymbol={{$baseCurrency}}
                toValue={{$reverseExchangeRate}}></x-currency-components.country-to-country-table>
        </div>
    </div>

    <script>
        let record = {}

        function interactiveChanges(){
            const exchangeRate = @json($exchangeRate);
            const countries = @json($countries);
            const baseCurrency = @json($baseCurrency);
            const targetedCurrency = @json($targetedCurrency);
            const amount = document.getElementById('amount');


            record.baseCurrency = baseCurrency;
            record.targetedCurrency = targetedCurrency;
            record.exchangeRate = exchangeRate;
            record.amount = amount.value;
            record.reverseExchangRate = @json($reverseExchangeRate);

            amount.addEventListener('keyup', () => {
                const convertedResult = document.getElementById('converted-result');
                record.amount = amount.value;
                convertedResult.textContent = amount.value + ' ' + countries[baseCurrency] + ' = ' + exchangeRate * amount.value +
                    ' ' + countries[targetedCurrency];
            });
        }


        async function bookmark(event){

            event.stopPropagation();
            // console.log('this is working');

            const url = @json(route('bookmark.store'));
            const response = await fetch(url,{
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
                },
                body: JSON.stringify(record),
            })

            if (!response.ok) {
               console.log(response.status);
            } else{
                const data = await response.json();
                console.log('API Response:', data);

                // Access the `id` field from the response
                console.log('ID:', data.id);

            }
        }

        interactiveChanges();



    </script>
</x-app-layout>
