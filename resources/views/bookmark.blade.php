<x-app-layout>
    <h1 class="text-4xl text-center mt-5 font-semibold">
        Bookmark
    </h1>
    <div class="flex justify-center mt-2 h-4">
        <p class=" text-red-400 flex items-center border-b-2 border-b-red-400 invisible h-0 opacity-0 overflow-hidden transition-all duration-700 ease-linear"
            id="bookmark-message">Bookmark has been deleted!<button type="button" class="material-icons"
                id="bookmark-close">
                close
            </button></p>
    </div>
    {{-- <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p> --}}

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">

            {{-- pages navigation --}}
            <x-currency-components.pages-navigation mb='mb-5'></x-currency-components.pages-navigation>
            <div class="sm:flex sm:justify-between sm:items-center">
                {{-- <div class="flex justify-center sm:w-1/2 ">
                    <a href="{{ route('bookmark.show') }}" class="p-2 bg-sky-900 text-white hover:bg-slate-300 hover:text-black border rounded-3xl">Show All</a>
                </div> --}}
                <form action="" method="GET" class="w-full sm:flex sm:justify-between items-center">
                    <x-currency-components.currency-dropbox :currencies="$currencies" destination='baseCurrency' labelName='From'
                        :oldSelected="$baseCurrency"></x-currency-components.currency-dropbox>
                    <div class="w-auto flex justify-center">
                        <x-currency-components.swap-button from='baseCurrency'
                            to='targetedCurrency'></x-currency-components.swap-button>
                    </div>
                    <x-currency-components.currency-dropbox :currencies="$currencies" destination='targetedCurrency' labelName='To'
                        :oldSelected="$targetedCurrency"></x-currency-components.currency-dropbox>
                    <div class="flex justify-center mt-1 sm:mt-0">
                        <button type="submit"
                            class="w-36 bg-blue-600 text-center p-3 my-1 font-semibold text-white rounded-3xl hover:bg-blue-500 transition ease-in-out duration-300">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4">
        @foreach ($userBookmarks as $bookmark)
            <div class="mt-2 rounded-lg bg-white p-3 border h-36 flex-none flex flex-col justify-between transition-all hover:-translate-y-0.5 hover:scale-105 duration-300" id="{{ $bookmark->id }}">


                {{-- Header --}}
                <p class="text-gray-400">{{ $bookmark->created_at->format('M d Y') }}</p>


                <div class="flex justify-between text-base">
                    <p>{{ $bookmark->amount . ' ' . $bookmark->baseCurrency->code }}</p>
                    <p class="material-icons text-blue-600">arrow_right_alt</p>
                    <p>{{ $bookmark->amount * $bookmark->exchange_rate . ' ' . $bookmark->targetedCurrency->code }}
                    </p>
                </div>
                <div>
                    <hr class="h-[3px] bg-sky-500 border-none">
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-sm text-gray-500">1 {{ $bookmark->baseCurrency->name }} =
                            {{ $bookmark->exchange_rate . ' ' . $bookmark->targetedCurrency->name }}</p>
                        <p class="text-sm text-gray-500">1 {{ $bookmark->targetedCurrency->name }} =
                            {{ $bookmark->reverse_exchange_rate . ' ' . $bookmark->baseCurrency->name }}</p>
                    </div>
                    <div>
                        <button type="button" onclick="cardRemove({{ $bookmark->id }})"
                            class="material-icons hover:text-red-500">
                            delete_forever
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 flex justify-around">
        {{ $userBookmarks->links() }}
    </div>
    <script>
        function cardRemove(id) {
            invokeDeleteRequestForBookmark(id);
            document.getElementById(id).remove();
        }

        async function invokeDeleteRequestForBookmark(id) {
            const url = @json(route('bookmark.destroy'));
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    id: id,
                }),
            })

            if (!response.ok) {
                console.log(response.status);
            } else {
                const data = await response.json();
                console.log('API Response:', data);

                // Access the `id` field from the response
                // console.log('ID:', data);
                const bookmarkMessage = document.getElementById('bookmark-message');
                bookmarkMessage.classList.remove('invisible', 'opacity-0', 'h-0');
                bookmarkMessage.classList.add('opacity-100', 'h-auto');
            }
        }

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
