@extends('home.partials.app')
@section('content')
    <section class="container">
        {{-- @include('home.main.slider') --}}

        @include('home.main.populars')


        {{-- @include('home.main.banner') --}}

        @if ($special->count() >= 1)
            @include('home.main.special')
        @endif


        {{-- @include('home.main.testimoni') --}}

    </section>
@endsection
