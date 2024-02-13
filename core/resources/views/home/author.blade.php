@extends('home.partials.app')
@push('style')
    <style type="text/css">
        .pagination li {
            float: left;
            list-style-type: none;
            margin: 5px;
        }
    </style>
@endpush
@section('content')
    <section class="container">'
        @include('home.partials.breadcubs')

        <h1 class="main-ttl"><span>{{ $title ?? '' }}</span></h1>
        <div class="prod-wrap">
            <div class="section-catalog">
                @php
                    $category = isset($_GET['category']) ? $_GET['category'] : false;
                    $search = isset($_GET['search']) ? $_GET['search'] : false;
                    $query = '';
                    if ($category) {
                        $query .= '&category=' . $category;
                    }
                    if ($search) {
                        $query .= '&search=' . $search;
                    }
                @endphp
                <!-- Pagination - start -->
                <div style="display:flex;justify-content:center">
                    <ul class="pagi ">
                        {{-- @dd(); --}}
                        @php
                            $totalPages = $catalog->lastPage();
                            $currentPage = $catalog->currentPage();
                            $result = calculatePages($currentPage, $totalPages);
                        @endphp
                        @if ($catalog->currentPage() != 1)
                            <li class="pagi-next">
                                <a href="{{ $catalog->previousPageUrl() . $query }}"><i
                                        class="fa fa-angle-double-left"></i></a>
                            </li>
                        @endif
                        @for ($i = $result['startPage'] - 1 != 0 ? $result['startPage'] - 1 : $result['startPage']; $i <= $result['lastPage']; $i++)
                            <li class="@if ($catalog->currentPage() == $i) active @endif"><a
                                    href="{{ url('author/' . $authorId . '?page=' . $i . $query) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($catalog->currentPage() != $catalog->lastPage())
                            <li class="pagi-next">
                                <a href="{{ $catalog->nextPageUrl() . $query }}"><i
                                        class="fa fa-angle-double-right"></i></a>
                            </li>
                        @endif

                    </ul>
                </div>
                <div class="prod-items section-items prod-items-galimg">
                    @foreach ($catalog as $cal)
                        <div class="prod-i" style="margin-bottom: 5px">
                            <div class="prod-i-top">
                                <a href="{{ url('product/' . $cal->product_slug) }}" class="prod-i-img">
                                    <!-- NO SPACE -->
                                    <img src="http://placehold.it/300x366" alt="Nulla numquam obcaecati">
                                    <img src="http://placehold.it/300x433" alt="Nulla numquam obcaecati">
                                    <img src="http://placehold.it/300x433" alt="Nulla numquam obcaecati">
                                    <img src="http://placehold.it/300x433" alt="Nulla numquam obcaecati">
                                    <!-- NO SPACE -->
                                </a>
                            </div>
                            <h3>
                                <a href="{{ url('product/' . $cal->product_slug) }}">{{ $cal->product_name }}</a>
                            </h3>
                            <div class="prod-i-action">
                                <p class="prod-i-info">
                                    <a href="#" class="prod-i-add qview-btn btnDetails"
                                        style="background-color: #A6CF98" data-id="{{ $cal->id }}"
                                        data-name="{{ $cal->product_name }}" data-price="{{ $cal->price }}"
                                        data-slug="{{ $cal->product_slug }}"
                                        data-category="{{ $cal->category->category_name }}"
                                        data-id_category="{{ $cal->id_category }}" data-tags="{{ $cal->tags() }}"
                                        data-desc="{{ $cal->description }}"><i class="fa fa-search"></i> Go to
                                        detail</a>
                                </p>
                                <p class="prod-i-price">
                                    <b class="text-info">Rp {{ number_format($cal->price, 0, ',', '.') }}</b>
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- Pagination - start -->
                <div style="display:flex;justify-content:center">
                    <ul class="pagi ">
                        @dd($authorId)
                        @if ($catalog->currentPage() != 1)
                            <li class="pagi-next">
                                <a href="{{ $catalog->previousPageUrl() . $query }}"><i
                                        class="fa fa-angle-double-left"></i></a>
                            </li>
                        @endif
                        @for ($i = $result['startPage'] - 1 != 0 ? $result['startPage'] - 1 : $result['startPage']; $i <= $result['lastPage']; $i++)
                            <li class="@if ($catalog->currentPage() == $i) active @endif"><a
                                    href="{{ url('author/' . $authorId . '?page=' . $i . $query) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($catalog->currentPage() != $catalog->lastPage())
                            <li class="pagi-next">
                                <a href="{{ $catalog->nextPageUrl() . $query }}"><i
                                        class="fa fa-angle-double-right"></i></a>
                            </li>
                        @endif

                    </ul>
                </div>

                <!-- Pagination - end -->
            </div>
        </div>
        @include('home.partials.related')
        <!-- Catalog Items | Gallery V2 - start -->

        @include('home.catalog.modal')


        <!-- Quick View Product - end -->
    </section>
@endsection
{{-- @include('home.partials.modal') --}}
