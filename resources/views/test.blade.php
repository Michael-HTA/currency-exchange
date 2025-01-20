<x-app-layout>
    @error('amount','base_currency','targeted_currency')
        {{$message}}
    @enderror
    <form action="{{url('test')}}" method="POST">
        @csrf
        <input name="amount" type="number">
        <input name="base_currency" type="text">
        <input name="targeted_currency" type="text">
        <button type="submit">Convert</button>
    </form>
</x-app-layout>
