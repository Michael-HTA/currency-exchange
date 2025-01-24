<x-app-layout>
    <h1 class="text-4xl text-center mt-5 font-semibold">
        Bookmark
    </h1>
    {{-- <p class="text-center mt-3">
        Check live foreign currency exchange rates
    </p> --}}
    <div id="resizableDiv" class="transition-all ease-in-out duration-700 w-0 bg-green-500 h-10"></div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">

            {{-- pages navigation --}}
            <x-currency-components.pages-navigation mb='mb-5'></x-currency-components.pages-navigation>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 sm:grid sm:grid-cols-2">
        @foreach ($userBookmarks as $bookmark)
            <div class="w-full mt-2 rounded-lg bg-white p-3 border h-36 flex flex-col justify-between transition ease-in-out hover:-translate-y-0.5 hover:scale-105 duration-300 sm:w-96 "
                id="{{ $bookmark->id }}">

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
                console.log('ID:', data);
            }
        }

        // const div = document.getElementById('resizableDiv');
        // setTimeout(() => {
        //     div.classList.remove('w-0');
        //     div.classList.add('w-96');
        // }, 1000); // Expands after 1 second
    </script>
</x-app-layout>
