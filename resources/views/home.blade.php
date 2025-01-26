@php
    $baseCurrencySymbol = '';
    $baseCurrencyName = '';
    $targetedCurrencyName = '';

    foreach ($currencies as $currency) {
        if ($currency->code === $baseCurrency) {
            $baseCurrencyName = $currency->name;
            $baseCurrencySymbol = $currency->symbol;
            break;
        }
    }

    foreach ($currencies as $currency) {
        if ($currency->code === $targetedCurrency) {
            $targetedCurrencyName = $currency->name;
            break;
        }
    }
@endphp
<x-app-layout>

    {{-- Header --}}
    <h1 class="text-4xl text-center mt-5 font-semibold">
        Currency Converter
    </h1>
    <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p>

    <div class="flex justify-center mt-2 h-4">
        <p class=" text-green-400 flex items-center border-b-2 border-b-green-400 invisible h-0 opacity-0 overflow-hidden transition-all duration-700 ease-linear"
            id="bookmark-message">Bookmark has been added!<button type="button" class="material-icons" id="bookmark-close">
                close
            </button></p>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            {{-- Navigation --}}
            <x-currency-components.pages-navigation></x-currency-components.pages-navigation>
            {{-- convert area --}}
            <form action="" method="GET" class="w-full">
                <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1 items-center">
                    @error('amount')
                        {{ $message }}
                    @enderror
                    <div
                        class="mt-1 sm:mt-0 border rounded-lg  p-3 w-full sm:w-1/3 focus-within:ring-1 focus-within:ring-sky-500 group hover:bg-slate-100">
                        <label for="amount" class="block text-gray-500">Amount</label>
                        <div class="flex ">
                            <span class="my-auto">{{$baseCurrencySymbol}}</span>
                            <input value="{{ isset($amount) ? $amount : '' }}" name="amount" min='0.00'
                                max="1000000" inputmode="numeric" type="number" step="any" id='amount'
                                class=" m-0 p-0 ml-1 border-0 w-auto  focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none group-hover:bg-slate-100">
                        </div>
                    </div>
                    <x-currency-components.currency-dropbox :currencies="$currencies" destination='baseCurrency'
                        labelName='From' :oldSelected="$baseCurrency"></x-currency-components.currency-dropbox>
                    <div class="w-auto flex justify-center">
                        <x-currency-components.swap-button from='baseCurrency'
                            to='targetedCurrency'></x-currency-components.swap-button>
                    </div>
                    <x-currency-components.currency-dropbox :currencies="$currencies" destination='targetedCurrency'
                        labelName='To' :oldSelected="$targetedCurrency"></x-currency-components.currency-dropbox>
                </div>


                {{-- result --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center">
                    <div class="flex rounded-xl p-3">
                        <div>
                            <p id='converted-result'>
                                {{ $amount . ' ' . $baseCurrencyName }} =
                                {{ $amount * $exchangeRate . ' ' . $targetedCurrencyName }}
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
                            </div>
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
            <x-currency-components.country-to-country-table :from="$baseCurrencyName" :fromSymbol="$baseCurrency" :to="$targetedCurrencyName"
                :toSymbol="$targetedCurrency" :toValue="$exchangeRate"></x-currency-components.country-to-country-table>
            <x-currency-components.country-to-country-table :from="$targetedCurrencyName" :fromSymbol="$targetedCurrency" :to="$baseCurrencyName"
                :toSymbol="$baseCurrency" :toValue="$reverseExchangeRate"></x-currency-components.country-to-country-table>
        </div>
    </div>

    <script>
        let record = {}

        function interactiveChanges() {
            const exchangeRate = @json($exchangeRate);
            const baseCurrencyName = @json($baseCurrencyName);
            const targetedCurrencyName = @json($targetedCurrencyName); 
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
                let value = parseFloat(amount.value)
                if (!isNaN(value)) {
                    value = value.toFixed(2);
                    record.amount = value;
                } else {
                    value = 0;
                }
                convertedResult.textContent = value + ' ' + baseCurrencyName + ' = ' + (Math.round(
                        exchangeRate *
                        value * 100) / 100) +
                    ' ' + targetedCurrencyName;

                // console.log(convertedResult.textContent);

            });
        }


        async function bookmark(event) {

            event.stopPropagation();
            // console.log('this is working');

            const url = @json(route('bookmark.store'));
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
                body: JSON.stringify({
                    amount: record.amount,
                    baseCurrency: record.baseCurrency,
                    targetedCurrency: record.targetedCurrency,
                    exchangeRate: record.exchangeRate,
                    reverse_exchange_rate: record.reverseExchangRate,
                }),
            })

            if (response.status >= 400) {
                console.log(response.status);
            } else {
                // const data = await response.json();
                // console.log('API Response:', data);

                // Access the `id` field from the response
                // console.log('ID:', data.id);

                const bookmarkMessage = document.getElementById('bookmark-message');
                bookmarkMessage.classList.remove('invisible', 'opacity-0', 'h-0');
                bookmarkMessage.classList.add('opacity-100', 'h-auto');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            interactiveChanges();
        });


        function closeMessage() {
            const bookmarkClose = document.getElementById('bookmark-close');
            bookmarkClose.addEventListener('click', () => {
                const bookmarkMessage = document.getElementById('bookmark-message');
                bookmarkMessage.classList.remove('opacity-100', 'h-auto');
                bookmarkMessage.classList.add('invisible', 'opacity-0', 'h-0');
            })
        }

        closeMessage();
    </script>
</x-app-layout>
