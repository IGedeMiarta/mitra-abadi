@extends('home.partials.app')
@section('content')
    <!-- Main Content - start -->
    <main>
        <section class="container">
            @include('home.partials.breadcubs')

            <!-- Single Product - start -->
            <div class="prod-wrap">

                <!-- Product Images -->
                <div class="prod-slider-wrap">
                    <div class="prod-slider">
                        <ul class="prod-slider-car">
                            <li class="float: left; list-style: none; position: relative; width: 464px;">
                                <a data-fancybox-group="popup-product" class="fancy-img" href="{{ url($product->images) }}"
                                    target="_blank">
                                    <img src="{{ $product->images() }}" alt="{{ $product->name }}">
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="prod-thumbs">
                        <ul class="prod-thumbs-car">
                            <li>
                                <a data-slide-index="1" href="#">
                                    <img src="{{ $product->images() }}" alt="">
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>

                <!-- Product Description/Info -->
                <div class="prod-cont">
                    <h1 class="main-ttl"><span>{{ $product->product_name }}</span></h1>
                    <div class="prod-info mb-5 row" style="margin-bottom: 10px">
                        <div class="col-md-12">
                            <p class="prod-skuttl">Brand</p>
                            <a href="{{ url('catalog?brand=' . $product->brand_id) }}">
                                <h3 class="item_current_price badge badge-dark"
                                    style="background-color: blue; border-radius: 0%">
                                    {{ $product->brand->name }}</h3>
                            </a>
                        </div>
                    </div>
                    <div class="prod-info row mb-5" style="margin-top: 50px">

                        <div class="col-md-4">
                            <p class="prod-skuttl">Inner Size</p>
                            <h3 class="item_current_price badge badge-primary "
                                style="background-color: gray; border-radius: 0%">
                                {{ $product->in_size }} mm</h3>
                        </div>
                        <div class="col-md-4">
                            <p class="prod-skuttl">Outer Size</p>
                            <h3 class="item_current_price badge badge-primary "
                                style="background-color: gray; border-radius: 0%">
                                {{ $product->out_size }} mm</h3>
                        </div>
                        <div class="col-md-4">
                            <p class="prod-skuttl">Wight</p>
                            <h3 class="item_current_price badge badge-primary "
                                style="background-color: gray; border-radius: 0%">
                                {{ $product->weight }} Kg</h3>
                        </div>

                    </div>
                    <div class="prod-info mt-5" style="margin-top: 50px">

                        <p class="prod-price">
                            @if ($disc)
                                <del>{{ nb($disc) }}</del>
                            @endif
                            <b class="item_current_price text-info">
                                {{ nb($price) }}</b>
                        </p>
                        <p class="prod-addwrap">
                            <a href="{{ url('chart-add?_xcode=' . $price * 111111 . '&product=' . $product->product_slug) }}"
                                class="prod-add" rel="nofollow">Add to cart</a>
                        </p>
                    </div>
                    <ul class="prod-info">
                        <p>{!! $details !!}</p>
                    </ul>
                </div>

            </div>

            {{-- related product here --}}
            @include('home.partials.related')
            {{-- end product related --}}


        </section>
    </main>
    <!-- Main Content - end -->
@endsection
