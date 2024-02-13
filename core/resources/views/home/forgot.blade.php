@extends('home.partials.app')
@section('content')
    <section class="container stylization maincont">

        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>Forgot Password</span></h1>
        <div class="row"style="display: flex;justify-content: center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('forgot.post') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email/Phone<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control is-valid" id="inputEmail3"
                                placeholder="Enter mail or phone" name="type"
                                value="{{ Session::has('user') ? Session::get('type') : '' }}">
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @if (Session::has('user'))
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3"
                                    placeholder="Enter mail or phone" name="email"
                                    value="{{ Session::get('user')->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Phone<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3"
                                    placeholder="Enter mail or phone" name="phone"
                                    value="{{ Session::get('user')->phone }}">
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10 " style="display: flex;justify-content: start;margin-top: 10px">
                            <span class="">Have an account? <a href="{{ route('login') }}">Login</a></span>
                            <hr>
                            <span class=""> Dont have account? <a href="{{ route('register') }}">Register</a></span>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit"
                                class="btn btn-primary">{{ Session::has('user') ? 'RESET PASSWORD' : 'CHECK ACCOUNT' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



    </section>
@endsection
