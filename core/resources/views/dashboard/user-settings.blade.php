@extends('dashboard.partials.app')

@section('content')
    <div class="container d-flex justify-content-center row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', auth()->user()->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ auth()->user()->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ auth()->user()->email }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="exampleInputPassword1" class="form-label">New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="exampleInputPassword1" class="form-label ">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1">
                            </div>
                            <div class="col-md-12">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
