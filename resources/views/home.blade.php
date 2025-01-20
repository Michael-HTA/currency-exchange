<x-app-layout>
    <h1 class="text-4xl text-center mt-10 font-semibold">
        M Currency Converter
    </h1>
    <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            <div class="flex justify-evenly border mt-5 rounded-3xl">
                <x-currency-components.currency-nav link="{{route('home')}}" :isActive='true' iconName='currency_exchange'
                    name='Convert'></x-currency-components.currency-nav>
                <x-currency-components.currency-nav link="{{route('chart')}}" :isActive='false' iconName='analytics'
                    name='Chart'></x-currency-components.currency-nav>
            </div>

            {{-- convert process --}}
            <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1 items-center">
                <div
                    class="mt-1 sm:mt-0 border rounded-lg  p-3 w-full sm:w-1/3 focus-within:ring-1 focus-within:ring-sky-500 group hover:bg-slate-100">
                    <label for="amount" class="block text-gray-500">Amount</label>
                    <div class="flex ">
                        <span class="my-auto">$</span>
                        <input min='0' inputmode="numeric" type="number" id='amount'
                            class=" m-0 p-0 border-0 w-full  focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none group-hover:bg-slate-100">
                    </div>
                </div>
                <x-currency-components.currency-dropbox destination='from'
                    labelName='From'></x-currency-components.currency-dropbox>
                <div class="w-auto flex justify-center">
                    <x-currency-components.swap-button></x-currency-components.swap-button>
                </div>
                <x-currency-components.currency-dropbox destination='to'
                    labelName='To'></x-currency-components.currency-dropbox>
            </div>

            {{-- result --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center">
                <div class="flex rounded-xl p-3">
                    <div>
                        <p id='converted-result'>
                            10000 US Dollars = 689.00 Australian Dollars
                        </p>
                        <p>
                            1 AUD = 0.62 US
                        </p>
                        <p>
                            1 USD = 1.61 AUD
                        </p>
                    </div>
                    <div class="flex items-center justify-center mt-2">
                        <button class="hover:text-blue-500">
                            <span class="material-icons block">
                                star
                            </span>
                            <p>
                                Bookmark!
                            </p>
                        </button>
                    </div>
                </div>
                <div>
                    <button
                        class="w-52 bg-blue-600 text-center p-3 my-1 font-semibold text-white rounded-3xl hover:bg-blue-500">Convert</button>
                </div>
            </div>
        </div>
        <div class="sm:flex sm:justify-between sm:space-x-10">
            <x-currency-components.country-to-country-table from='US Dollar' fromSymbol='USD' to='Euro'
                toSymbol='EUR' toValue=0.972></x-currency-components.country-to-country-table>
            <x-currency-components.country-to-country-table from='Euro' fromSymbol='EUR' to='US Dollar'
                toSymbol='USD' toValue=1.028></x-currency-components.country-to-country-table>
        </div>
    </div>

    <script>
        const from = 1;
        const to = 0.62;
        const amount = document.getElementById('amount');
        amount.addEventListener('keyup', () => {
            const convertedResult = document.getElementById('converted-result');
            convertedResult.textContent = amount.value + ' USD = ' + to * amount.value + ' Australian Dollar';
        });
    </script>
</x-app-layout>
