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

        <h1 class="main-ttl"><span>Cart</span></h1>
        <!-- Cart Items - start -->
        <form action="{{ url('trasaction') }}" method="POST" id="cartForm">
            @csrf
            <div class="cart-items-wrap">
                <table class="cart-items">
                    <thead>
                        <tr>
                            <td class="cart-image">Photo</td>
                            <td class="cart-ttl">Products</td>
                            <td class="cart-price">Price</td>
                            <td class="cart-quantity">Quantity</td>
                            <td class="cart-summ">Summ</td>
                            <td class="cart-del">&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($chart as $crt)
                            @php
                                $sts = $crt->product->stock > 0 ? false : true;
                            @endphp
                            <tr
                                @if ($sts) style="background: linear-gradient(90deg, rgba(253,29,29,1) 3%, rgba(255,255,255,1) 100%);" @endif>
                                <td class="cart-image">
                                    <a href="{{ url('product/' . $crt->product->product_slug) }}">
                                        <img src="{{ url($crt->product->images) }}" alt="Similique delectus totam">
                                    </a>
                                </td>
                                <td class="cart-ttl">
                                    <a
                                        href="{{ url('product/' . $crt->product->product_slug) }}">{{ $crt->product->product_name }}</a>
                                    <p><b>Category: </b>{{ $crt->product->category->category_name }}</p>
                                    <p><b>Brand: </b>{{ $crt->product->brand->name }}</p>
                                    <p><b>Stock: </b>{{ $crt->product->stock }}</p>
                                    @if (!$sts)
                                        <input type="hidden" name="product[]" value="{{ $crt->product->id }}">
                                    @endif
                                </td>
                                <td class="cart-price">
                                    <b>{{ nb($crt->price) }}</b>
                                    @if (!$sts)
                                        <input type="hidden" name="price[]" value="{{ $crt->price }}">
                                    @endif

                                </td>
                                <td class="cart-quantity">
                                    <p class="cart-qnt">

                                        <input type="number" name="qty[]" value="{{ !$sts ? $crt->qty : 0 }}"
                                            class="form-control qtyInp" data-id="{{ $crt->id }}"
                                            @if ($sts) disabled @endif>

                                    </p>
                                </td>
                                <td class="cart-summ">
                                    <b>{{ nb($crt->price * $crt->qty) }}</b>
                                    <p class="cart-forone">unit price <b>{{ nb($crt->price) }}</b></p>
                                    @if (!$sts)
                                        <input type="hidden" name="total[]"
                                            value="{{ !$sts ? $crt->price * $crt->qty : 0 }}">
                                    @endif
                                </td>
                                <td class="cart-del">
                                    <a href="{{ url('chart-del/' . $crt->id) }}" class="cart-remove"></a>
                                </td>
                            </tr>
                            @php
                                $total += !$sts ? $crt->price * $crt->qty : 0;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="cart-total">
                <li class="cart-summ">TOTAL: <b>{{ nb($total) }}</b></li>
                <input type="hidden" name="amount" id="amount" value="{{ $total }}">
            </ul>
            <div class="cart-submit">
                <a href="#" class="cart-submit-btn disabled"
                    onclick=" @if ($total <= 0) return false;  @else  submitForm() @endif"
                    style="@if ($total <= 0) background-color: #9EB8D9; @else background-color: #2B3499; @endif">Checkout</a>
                {{-- <button type="submit" class="cart-submit-btn" target="_blank"
                    style="@if ($total <= 0) background-color: #9EB8D9; @else background-color: #2B3499; @endif">Checkout</button> --}}
                <a href="{{ url('chart-del-all') }}" class="cart-submit-btn"
                    style="@if ($total <= 0) background-color: #FFC5C5; pointer-events: none; @else background-color: #C70039 ; @endif">Clear
                    cart</a>
            </div>
        </form>
        <!-- Cart Items - end -->

    </section>
@endsection
@push('script')
    <script>
        function submitForm() {
            var url = "{{ Request::url() }}";
            var newTab = window.open(url, '_blank');

            // Check if the new tab has been successfully opened
            if (newTab) {
                // Get the form HTML
                var formHtml = $('#cartForm').prop('outerHTML');

                // Append the form HTML to the new tab's document body
                $(newTab.document.body).html(formHtml);

                // Submit the form in the new tab
                $(newTab.document.body).find('#cartForm').submit();

                setTimeout(function() {
                    window.open('', '_self').location.reload(true); // Reload the last tab
                }, 2000);
            } else {
                // Handle the case where the new tab couldn't be opened
                alert('Unable to open a new tab. Please check your browser settings.');
            }
        }
        $('.qtyInp').on('change', function() {
            let qty = $(this).val();
            const id = $(this).data('id');
            $.ajax({
                url: "{{ url('/api/chart-qty') }}" + `${id}?qty=${qty}`,
                method: 'GET',
                dataType: 'json',
                success: function(rs) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        });
    </script>
@endpush
