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

<script>
    async function bookmark(event) {

        event.stopPropagation();
        // console.log('this is working');

        const url = @json(route('bookmark.store'));
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                amount: record.amount,
                baseCurrency: record.baseCurrency,
                targetedCurrency: record.targetedCurrency,
                exchangeRate: record.exchangeRate,
                reverseExchangeRate: record.reverseExchangeRate,
            }),
        })

        if (!response.ok) {
            const data = await response.json();
            console.log('API Response:', data);
            // console.log(response.status);
        } else {
            // const data = await response.json();
            // console.log('API Response:', data);

            // Access the `id` field from the response
            // console.log('ID:', data.id);
            // console.log(response.status);
            const bookmarkMessage = document.getElementById('bookmark-message');
            bookmarkMessage.classList.remove('invisible', 'opacity-0', 'h-0');
            bookmarkMessage.classList.add('opacity-100', 'h-auto');
        }
    }
</script>
