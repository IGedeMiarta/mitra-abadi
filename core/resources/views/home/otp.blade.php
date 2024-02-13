@extends('home.partials.app')
@section('content')
    <section class="container stylization maincont">

        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>OTP</span></h1>
        <div class="row"style="display: flex;justify-content: center">

            <div class="col-md-6">

                <form method="POST" action="{{ route('otp.post') }}">
                    <div class="alert bg-success" role="alert">
                        The OTP code has been sent to the <b>WhatsApp</b> number registered in your account, please check or
                        request a new <a href="#">OTP code</a>
                    </div>
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">OTP<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control is-valid" id="inputEmail3"
                                placeholder="Enter OTP Code" name="otp">
                            @if ($errors->has('otp'))
                                <div class="text-danger">
                                    {{ $errors->first('otp') }}
                                </div>
                            @endif

                        </div>
                    </div>
                    @if (Session::has('user'))
                        <input type="hidden" class="form-control" id="inputEmail3" placeholder="Enter mail or phone"
                            name="type" value="{{ Session::get('user')->email }}">
                        <input type="hidden" class="form-control" id="inputEmail3" placeholder="Enter mail or phone"
                            name="phone" value="{{ Session::get('user')->phone }}">
                    @endif
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">VALIDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </section>
@endsection
