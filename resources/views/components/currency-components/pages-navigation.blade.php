@php
    $marginBottom = $mb ?? '';
@endphp
<div class="flex justify-evenly border mt-5 {{$marginBottom}} rounded-3xl">
    <x-currency-components.currency-nav
        link="{{route('home')}}"
        :isActive="request()->routeIs('home') ? true : false"
        iconName="currency_exchange"
        name="Convert">
    </x-currency-components.currency-nav>

    <x-currency-components.currency-nav
        link="{{route('chart')}}"
        :isActive="request()->routeIs('chart') ? true : false"
        iconName="analytics"
        name="Chart">
    </x-currency-components.currency-nav>

    @auth
        <x-currency-components.currency-nav
            link="{{route('bookmark.show')}}"
            :isActive="request()->routeIs('bookmark.show') ? true : false"
            iconName="bookmarks"
            name="Bookmark">
        </x-currency-components.currency-nav>
    @endauth
</div>
