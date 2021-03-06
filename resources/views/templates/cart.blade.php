@extends('templates.default')

@section('page.title', 'Mon panier - ' . App\Setting::valueOrNull('SHOP_NAME'))

@section('page.content')
    @hook(['code' => 'public.cart.top'])

    <div class="row mb-3">
        <div class="col-12">
            <p id="breadcrumb">
                / <a href="{{ route('index') }}">Accueil</a>
                / <a href="{{ route('cart') }}">Mon panier</a>
                @yield('cart.breadcrumb')
            </p>
            <h1 class="h3">@yield('cart.title', 'Mon panier')</h1>
        </div>
    </div>

    @include('themes.default.components.alerts.error')

    <div class="row">
        @if (0 !== count($cart->items))

        {{-- STEP CONTENT --}}
        <div class="col-12 col-lg-8 d-flex flex-column">
            @yield('cart.content')
        </div>

        {{-- CART SUMMARY --}}
        <div class="col-12 col-lg-4">
            <div class="bg-white shadow-sm p-3">
                <p>{{ $cart->totalQuantity }} articles : {{ $cart->totalPriceFormatted }}</p>
                <p>Frais de port : {{ $cart->shippingCostsFormatted }}</p>
                <p>Total : {{ $cart->totalPriceWithShippingCostsFormatted }}</p>

                @yield('cart.summary.next-button')
            </div>

            @yield('cart.summary.other')
        </div>

        @else

        {{-- NO ITEMS IN CART --}}
        <div class="col-12">
            <div class="bg-white shadow-sm p-3">
                <h2 class="h5 text-center mb-0">Votre panier est vide.</h2>
            </div>
        </div>

        @endif
    </div>

    @hook(['code' => 'public.cart.bottom'])
@endsection
