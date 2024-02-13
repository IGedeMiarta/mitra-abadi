@extends('home.partials.app')
@push('style')
    <style>
        .disableBtn {
            pointer-events: none;
            cursor: default;

        }
    </style>
@endpush
@section('content')
    <section class="container stylization maincont">

        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>{{ $title ?? '' }}</span></h1>
        <!-- Cart Items - start -->
        <div class="cart-items-wrap">
            <table class="cart-items">
                <thead>
                    <tr>
                        <td class="cart-ttl">Products</td>
                        <td class="cart-quantity">Qty</td>
                        <td class="cart-price">Price</td>
                        <td class="cart-summ">Status</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($table as $item)
                        <tr>

                            <td class="cart-ttl">
                                <a href="{{ url('invoice/' . $item->Invoice) }}" target="_blank"
                                    style="color: #7071E8">#{{ $item->Invoice }}</a>

                                @foreach ($item->details as $i => $d)
                                    <p>{{ $i + 1 . '. ' . $d->product->product_name }}</p>
                                @endforeach

                            </td>
                            <td class="cart-quantity">
                                <p class="cart-qnt">{{ $item->details->count() }}</p>
                            </td>
                            <td class="cart-price">
                                <b>{{ nb($item->amount) }}</b>
                            </td>

                            <td class="cart-summ">
                                <b>{!! $item->status() !!}</b>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- Cart Items - end -->

    </section>
@endsection
