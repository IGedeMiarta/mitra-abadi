@extends('home.partials.app')
@section('content')
    <section class="container stylization maincont">
        @include('home.partials.breadcubs')
        <hr>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-5">
                <form action="{{ url('profile', auth()->user()->id) }}" method="POST">
                    @csrf
                    @method('PUT');
                    <h1 class="main-ttl"><span>{{ 'USER ACCOUNT' }}</span></h1>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Enter Email"
                                name="email" value="{{ $user->email }}" disabled>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Phone Number<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Phone Number"
                                name="phone" value="{{ $user->phone }}" disabled>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name"
                                name="name" value="{{ $user->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Address<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea name="address" placeholder="Address.." id="" cols="30" rows="10">{{ $user->address }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex" style="display: flex; justify-content: end">
                        <div class="cart-submit">
                            <button type="submit" class="cart-submit-btn" style="background-color: #525CEB">
                                Update</button>
                        </div>
                </form>
                <form action="{{ url('/logout') }}" id="form" method="POST">
                    @csrf
                    <div class="cart-submit">
                        <a href="#" class="cart-submit-btn" style="background-color: #FA7070" onclick="submitForm()">
                            LOGOUT</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <h1 class="main-ttl"><span>{{ 'Order History' }}</span></h1>

            <div class="cart-items-wrap">
                <table class="cart-items">
                    <thead>
                        <tr>
                            <td class="cart-ttl">Products</td>
                            <td class="cart-date">Date</td>
                            <td class="cart-price">Price</td>
                            <td class="cart-summ">Payment Details</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($table as $item)
                            <tr>

                                <td class="cart-ttl">
                                    <a href="{{ url('invoice/' . $item->Invoice) }}" target="_blank"
                                        style="color: #7071E8">#{{ $item->Invoice }}</a>

                                    @foreach ($item->details as $i => $d)
                                        <p>{{ $d->qty . ' | ' . $d->product->product_name }}</p>
                                    @endforeach

                                </td>
                                <td class="cart-date" style="color:#7D7C7C">{{ dates($item->created_at) }}</td>


                                <td class="cart-price">
                                    <b>{{ nb($item->amount) }}</b> <br>
                                    <b>{!! $item->status() !!}</b><br>
                                    <b>Shipment: {!! $item->shipment() !!}</b>
                                </td>
                                {{-- 
                                    <td class="cart-summ">
                                        <b>{!! $item->status() !!}</b>
                                    </td> --}}
                                <td>
                                    @if ($item->trx_img_2 === null && ($item->dp != 0 || $item->trx_img_1 === null))
                                        <button class="cart-submit-btn qview-btn btnUpload"
                                            style="background-color: #86A7FC" data-inv="#{{ $item->Invoice }}"
                                            data-price="{{ nb($item->amount) }}" data-id="{{ $item->id }}"
                                            data-url="{{ url('invoice/' . $item->Invoice) }}">Upload
                                            Struk </button>
                                    @else
                                        <img src="{{ asset($item->trx_img_1) }}" alt="img-{{ $item->Invoice }}">
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <td colspan="4">
                                <b>
                                    <center>
                                        No orders yet!
                                    </center>
                                </b>
                            </td>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
        </div>

    </section>
    @include('home.modal-upload')

@endsection
@push('script')
    <script>
        function submitForm() {
            // Submit the form
            document.getElementById('form').submit();
        }
    </script>
@endpush
