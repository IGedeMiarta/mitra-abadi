@extends('home.partials.app')
@section('content')
    <section class="container stylization maincont">

        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>Login</span></h1>
        <div class="row"style="display: flex;justify-content: center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email/Phone<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Email or Phone"
                                name="type" value="{{ old('type') }}">
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label" style="margin-top: 20px">Password<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10" style="text-align: start">
                            {{-- <span class=""> <a href="{{ route('register') }}">Forgot My
                                    Password</a></span> --}}
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Enter Password"
                                name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10 " style="display: flex;justify-content: start;margin-top: 10px">
                            <span class=""> Dont have account? <a href="{{ route('register') }}">Register</a></span>
                            <hr>
                            <span class=""><a href="{{ route('forgot') }}">Forgot Password</a></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </section>
@endsection
