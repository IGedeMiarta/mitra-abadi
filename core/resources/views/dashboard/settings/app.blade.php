@extends('dashboard.partials.app')
@push('style')
    <!-- page css -->
    <link href="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
@endpush
@section('content')
    <form action="" method="POST">
        @csrf
        <div class="d-flex justify-content-end ml-4 mr-4">
            <button type="submit" class="btn btn-primary mb-3"><i class="anticon anticon-check mr-2"></i>Save
                {{ $title }}</button>
        </div>

        <div class="row d-flex justify-content-center">

            <div class="card col-md-5 mr-3 ml-5">
                <div class="card-body mb-n5">
                    <h3>APP Settings</h3>
                </div>
                <hr>
                <div class="card-body mt-n5">
                    @foreach ($apps as $app)
                        <div class="mt-4">
                            <label for="name">{{ $app->key }}</label>
                            <input type="text" name="{{ $app->key }}" value="{{ $app->value }}"
                                class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card col-md-5 mr-3 ml-5 d-none">
                <div class="card-body mb-n5">
                    <h3>Mail Settings</h3>
                </div>
                <hr>
                <div class="card-body mt-n5">
                    @foreach ($mail as $bank)
                        <div class="mt-4">
                            <label for="name">{{ $bank->key }}</label>
                            <input type="text" name="{{ $bank->key }}" value="{{ $bank->value }}"
                                class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card col-md-5 mr-3 ml-5">
                <div class="card-body mb-n5">
                    <h3>BANK Settings</h3>
                </div>
                <hr>
                <div class="card-body mt-n5">
                    @foreach ($banks as $bank)
                        <div class="mt-4">
                            <label for="name">{{ $bank->key }}</label>
                            <input type="text" name="{{ $bank->key }}" value="{{ $bank->value }}"
                                class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card col-md-5 mr-3 ml-5">
                <div class="card-body mb-n5">
                    <h3>WhatsApp Settings</h3>
                </div>
                <hr>
                <div class="card-body mt-n5">
                    @foreach ($wa as $bank)
                        <div class="mt-4">
                            <label for="name">{{ $bank->key }}</label>
                            <input type="text" name="{{ $bank->key }}" value="{{ $bank->value }}"
                                class="form-control">
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
    </form>
@endsection
