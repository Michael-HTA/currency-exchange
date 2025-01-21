<div
    class="mt-1 sm:mt-0 border rounded-lg  p-3 w-full sm:w-1/3 focus-within:ring-1 focus-within:ring-sky-500 group hover:bg-slate-100">
    <label class="text-gray-500 block" for="{{ $destination }}">{{ $labelName }}</label>
    <select name="{{ $destination }}" id="{{ $destination }}"
        class="w-full border-0 focus:ring-0 m-0 p-0 group-hover:bg-slate-100">
        @foreach ($countries as $key => $value)
        <option value="{{ $key }}" {{ $oldSelected == $key ? 'selected' : '' }}>
            {{ $key }} - {{ $value }}
        </option>
    @endforeach
    </select>
</div>
