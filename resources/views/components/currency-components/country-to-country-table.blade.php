@php
    $defaultRate = [1, 5, 10, 25, 50, 100, 500, 1000, 5000, 10000];
@endphp
<div class="w-full sm:w-2/4">
    <div class="w-full text-center font-bold text-3xl my-10">{{$from}} to {{$to}}</div>
    <table class="w-full bg-slate-100 rounded-3xl overflow-hidden">
        <thead>
            <tr class="bg-slate-300">
                <th class="p-3">{{$from}}</th>
                <th class="p-3">{{$to}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($defaultRate as $rate)
                <tr>
                    <td class="text-center p-3 font-bold text-blue-600">{{ $rate . ' ' . $fromSymbol }}</td>
                    <td class="text-center p-3 font-bold">{{ ($rate * $toValue) . ' ' . $toSymbol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
