<a href="{{ $link }}"
    class="{{ $isActive ? 'bg-sky-900 text-white' : '' }} font-medium hover:bg-slate-300 hover:text-black w-32 sm:w-60 my-1 border rounded-3xl flex justify-center p-3 items-center
    transition ease-in-out duration-300">
    <span class="material-icons mr-1">{{ $iconName }}</span>
    {{ $name }}
</a>
