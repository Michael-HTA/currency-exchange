<x-app-layout>
    <h1 class="text-4xl text-center mt-10 font-semibold">
        M Currency Converter
    </h1>
    <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">
            <div class="flex justify-evenly border mt-5 rounded-3xl" id="nav-tag">
            </div>
            <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1">
                <div
                    class="border rounded-lg p-2 w-full sm:w-1/3 focus-within:ring-1 focus-within:ring-sky-500 hover:bg-slate-100 group">
                    <label for="amount" class="block">Amount</label>
                    <div class="flex">
                        <span class="my-auto">$</span>
                        <input min='0' inputmode="numeric" type="number" id='amount'
                            class="border-0 w-full  focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none group-hover:bg-slate-100">
                    </div>
                </div>
                <x-currency-components.currency-dropbox destination='from'
                    labelName='From'></x-currency-components.currency-dropbox>
                <x-currency-components.currency-dropbox destination='to'
                    labelName='To'></x-currency-components.currency-dropbox>

            </div>
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
                        <button>
                            <span class="material-icons block">
                                favorite_border
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
            <x-currency-components.country-to-country-table from='US Dollar' to='Euro' toValue=0.972 ></x-currency-components.country-to-country-table>
            <x-currency-components.country-to-country-table from='Euro' to='US Dollar' toValue=1.028></x-currency-components.country-to-country-table>
        </div>
    </div>

    <script>
        const navTag = document.getElementById('nav-tag');
        const classNameForNavTag =
            'font-medium hover:bg-slate-300  w-60 p-1 my-1 border rounded-3xl flex justify-center p-3';
        const navList = [{
                name: 'Convert',
                iconClass: 'material-icons',
                iconName: 'currency_exchange'
            },
            {
                name: 'Chart',
                iconClass: 'material-icons',
                iconName: 'analytics',
            },
        ];

        const clearSelection = () => {
            const items = navTag.querySelectorAll('div');
            items.forEach(item => item.classList.remove('bg-sky-900', 'text-white'));
        };

        navList.forEach((data) => {
            const div = document.createElement('div');
            const a = document.createElement('a');
            const span = document.createElement('span');


            span.textContent = data.iconName;
            span.className = data.iconClass + ' mr-1';

            div.className = classNameForNavTag;

            div.addEventListener('click', () => {
                clearSelection();
                div.classList.add('bg-sky-900', 'text-white');
            });

            a.textContent = data.name;
            div.appendChild(span);
            div.appendChild(a);
            navTag.appendChild(div);
        });

        const from = 1;
        const to = 0.62;
        const amount = document.getElementById('amount');
        amount.addEventListener('keyup',() => {
           const convertedResult = document.getElementById('converted-result');
           convertedResult.textContent = amount.value + ' USD = ' + to * amount.value + ' Australian Dollar';
        });


    </script>

    </script>
</x-app-layout>
