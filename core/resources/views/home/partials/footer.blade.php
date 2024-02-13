<!-- Footer - start -->
<footer class="footer-wrap">

    <div class="container f-menu-list">
        <div class="row">
            <div class="f-menu">
                <h3>
                    Categories
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    @foreach (App\Models\Categories::all() as $item)
                        <li><a
                                href="{{ url('catalog?category=' . $item->category_slug) }}">{{ ucwords(str_replace('templates', '', strtolower($item->category_name))) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="f-menu">
                <h3>
                    Pages
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{ url('login') }}">Login</a></li>
                    <li><a href="{{ url('register') }}">Register</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contacts</a></li>
                </ul>
            </div>
            <div class="f-menu">
                <h3>
                    Home
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    <li @if (request()->is('/')) class="active" @endif>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li @if (request()->is('catalog')) class="active" @endif>
                        <a href="{{ url('/catalog') }}">Catalog</a>
                    </li>
                    <li><a href="#">Contacts</a></li>
                </ul>
            </div>
            <div class="f-menu">
                <h3>
                    Information
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">Carrier</a></li>
                </ul>
            </div>
            <div class="f-subscribe">
                <h3>Subscribe to news</h3>
                <form class="f-subscribe-form" action="#">
                    <input placeholder="Your e-mail" type="text">
                    <button type="submit"><i class="fa fa-paper-plane"></i></button>
                </form>
                <p>Enter your email address if you want to receive our newsletter. Subscribe now!</p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
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
                <div class="footer-copyright">
                    <i><a href="{{ url('/') }}">{{ app_data('app') }}</a></i> © Copyright 2023
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- Footer - end -->
