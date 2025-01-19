<x-app-layout>
    <h1 class="text-white text-4xl text-center mt-10 font-semibold">
        M Currency Converter
    </h1>
    <p class="text-center text-white mt-3">
        Check live foreign currency exchange rates
    </p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-3">

            <div class="flex justify-evenly border mt-5 rounded-3xl">
                <x-currency-components.currency-nav link="{{route('home')}}" :isActive='false' iconName='currency_exchange'
                    name='Convert'></x-currency-components.currency-nav>
                <x-currency-components.currency-nav link="{{route('chart')}}" :isActive='true' iconName='analytics'
                    name='Chart'></x-currency-components.currency-nav>
            </div>

            <div class="w-full sm:flex sm:justify-around my-3 sm:space-x-1 items-center">
                <x-currency-components.currency-dropbox destination='from'
                    labelName='From'></x-currency-components.currency-dropbox>
                <div class="w-auto flex justify-center">
                    <x-currency-components.swap-button></x-currency-components.swap-button>
                </div>
                <x-currency-components.currency-dropbox destination='to'
                    labelName='To'></x-currency-components.currency-dropbox>
            </div>
        </div>
    </div>
</x-app-layout>
