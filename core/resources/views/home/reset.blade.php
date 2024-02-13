@extends('home.partials.app')
@section('content')
    <section class="container stylization maincont">

        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>Reset Password</span></h1>
        <div class="row"style="display: flex;justify-content: center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('reset.post') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Enter Email"
                                name="email" value="{{ Session::get('user')->email }}" readonly>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Enter New Password"
                                name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Retype Password<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3"
                                placeholder="Retype New Password" id="password_confirmation" name="password_confirmation">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </section>
@endsection
