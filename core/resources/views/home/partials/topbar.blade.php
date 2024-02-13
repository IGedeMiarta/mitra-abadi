<!-- Topbar - start -->
<div class="header_top">
    <div class="container">
        <ul class="contactinfo nav nav-pills">
            <li>
                <i class='fa fa-phone'></i> {{ app_data('phone') }}
            </li>
            <li>
                <i class="fa fa-envelope"></i> {{ app_data('email') }}
            </li>
        </ul>
        <!-- Social links -->
        <ul class="social-icons nav navbar-nav">
            <li>
                <a href="http://facebook.com/" rel="nofollow" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li>
                <a href="http://twitter.com/" rel="nofollow" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li>
                <a href="http://instagram.com/" rel="nofollow" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Topbar - end -->
<!-- Logo, Shop-menu - start -->
<div class="header-middle">
    <div class="container header-middle-cont">
        <div class="toplogo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}" alt="AllStore - MultiConcept eCommerce Template">
            </a>
        </div>
        <div class="shop-menu">
            <ul>

                @if (!auth()->user())
                    <li class="topauth">
                        <a href="{{ url('register') }}">
                            <i class="fa fa-lock"></i>
                            <span class="shop-menu-ttl">Registration</span>
                        </a>
                        <a href="{{ url('login') }}">
                            <span class="shop-menu-ttl">Login</span>
                        </a>
                    </li>
                @else
                    <li class="topauth">
                        @if (auth()->user()->role == 'cust')
                            <a href="{{ url('profile') }}" style="color: green">
                                <i class="fa fa-user" style="color: green"></i>
                                <span class="shop-menu-ttl">{{ auth()->user()->name }}</span>
                            </a>
                        @else
                            <a href="{{ url(auth()->user()->role . '/dashboard') }}" style="color: green">
                                <i class="fa fa-user" style="color: green"></i>
                                <span class="shop-menu-ttl">{{ auth()->user()->name }}</span>
                            </a>
                        @endif

                        <a href="{{ url('chart') }}" style="color: blue">
                            <i class="fa fa-shopping-cart" style="color: blue"></i>
                            <span class="shop-menu-ttl">Cart</span> <span class="badge "
                                style="color: white;background-color: blue"><b class="userID"
                                    data-user_id="{{ auth()->user()->id }}">0</b></span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- Logo, Shop-menu - end -->
<!-- Topmenu - start -->
<div class="header-bottom">
    <div class="container">
        <nav class="topmenu">
            <!-- Catalog menu - start -->
            <div class="topcatalog">
                <a class="topcatalog-btn" href="{{ url('catalog') }}"><span>All</span> catalog</a>
                <ul class="topcatalog-list">
                    @foreach (App\Models\Categories::all() as $i)
                        <li>
                            <a href="{{ url('catalog?category=' . $i->category_slug) }}">
                                {{ str_replace('TEMPLATES', '', strtoupper($i->category_name)) }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <!-- Catalog menu - end -->

            <!-- Main menu - start -->
            <button type="button" class="mainmenu-btn">Menu</button>

            <ul class="mainmenu">
                {{-- <li>
                    <a href="#" class="active">
                        Login
                    </a>
                </li>
                <li>
                    <a href="#" class="active">
                        Regiter
                    </a>
                </li> --}}

            </ul>
            <!-- Main menu - end -->

            <!-- Search - start -->
            <div class="topsearch">
                <a id="topsearch-btn" class="topsearch-btn" href="#"><i class="fa fa-search"></i></a>
                <form class="topsearch-form" action="{{ url('catalog') }}" method="GET">
                    @if ($category)
                        <input type="hidden" name="category" value="{{ $category }}">
                    @endif
                    <input type="text" placeholder="Search products" name="search"
                        value="{{ $_GET['search'] ?? '' }}">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <!-- Search - end -->

        </nav>
    </div>
</div>
<!-- Topmenu - end -->
@push('script')
    <script>
        const userID = $('.userID').data('user_id');
        $.ajax({
            url: "{{ url('/api/chart') }}" + `/${userID}`,
            method: 'GET',
            dataType: 'json',
            success: function(rs) {
                $('.userID').html(rs.count);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    </script>
@endpush
