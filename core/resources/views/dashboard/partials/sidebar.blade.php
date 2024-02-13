 <!-- Side Nav START -->
 @php
     $url = auth()->user()->role;
 @endphp
 <div class="side-nav">
     <div class="side-nav-inner">
         <ul class="side-nav-menu scrollable">
             <li class="nav-item dropdown {{ request()->is($url . '/dashboard') ? 'active' : '' }}"">
                 <a href="{{ url($url . '/dashboard') }}">
                     <span class="icon-holder">
                         <i class="anticon anticon-home"></i>
                     </span>
                     <span class="title">Dahboard</span>
                 </a>
             </li>
             @if ($url == 'admin')
                 <li class="nav-item dropdown">
                     <a class="dropdown-toggle" href="javascript:void(0);">
                         <span class="icon-holder">
                             <i class="anticon anticon-pie-chart"></i>
                         </span>
                         <span class="title">Master Data</span>
                         <span class="arrow">
                             <i class="arrow-icon"></i>
                         </span>
                     </a>
                     <ul class="dropdown-menu">
                         <li class="{{ request()->is($url . '/categories') ? 'active' : '' }}">
                             <a href="{{ url($url . '/categories') }}">Categories</a>
                         </li>
                         <li class="{{ request()->is($url . '/brand') ? 'active' : '' }}">
                             <a href="{{ url($url . '/brand') }}">Brand</a>
                         </li>
                         <li class="{{ request()->is($url . '/products') ? 'active' : '' }}">
                             <a href="{{ url($url . '/products') }}">Products</a>
                         </li>
                         <li class="{{ request()->is($url . '/special-products') ? 'active' : '' }}">
                             <a href="{{ url($url . '/special-products') }}">Discount Product</a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item dropdown">
                     <a class="dropdown-toggle" href="javascript:void(0);">
                         <span class="icon-holder">
                             <i class="anticon anticon-dashboard"></i>
                         </span>
                         <span class="title">Transaction</span>
                         <span class="arrow">
                             <i class="arrow-icon"></i>
                         </span>
                     </a>
                     <ul class="dropdown-menu">
                         <li class="{{ request()->is($url . '/stock') ? 'active' : '' }}">
                             <a href="{{ url($url . '/stock') }}">Stock Opname</a>
                         </li>
                         <li class="{{ request()->is($url . '/transaction') ? 'active' : '' }}">
                             <a href="{{ url($url . '/transaction') }}">Penjualan</a>
                         </li>
                     </ul>
                 </li>
             @endif


             <li class="nav-item dropdown">
                 <a class="dropdown-toggle" href="javascript:void(0);">
                     <span class="icon-holder">
                         <i class="anticon anticon-bar-chart"></i>
                     </span>
                     <span class="title">Report</span>
                     <span class="arrow">
                         <i class="arrow-icon"></i>
                     </span>
                 </a>
                 <ul class="dropdown-menu">
                     <li class="{{ request()->is($url . '/report/customer') ? 'active' : '' }}">
                         <a href="{{ url($url . '/report/customer') }}">Customer</a>
                     </li>
                     <li class="{{ request()->is($url . '/report/selling') ? 'active' : '' }}">
                         <a href="{{ url($url . '/report/selling') }}">Selling</a>
                     </li>
                     <li class="{{ request()->is($url . '/report/discount') ? 'active' : '' }}">
                         <a href="{{ url($url . '/report/discount') }}">Discount</a>
                     </li>
                     @if ($url == 'admin')
                         <li class="{{ request()->is($url . '/report/product') ? 'active' : '' }}">
                             <a href="{{ url($url . '/report/product') }}">Product</a>
                         </li>
                         {{-- <li class="{{ request()->is($url . '/report/category') ? 'active' : '' }}">
                             <a href="{{ url($url . '/report/category') }}">Categories</a>
                         </li>
                         <li class="{{ request()->is($url . '/report/brand') ? 'active' : '' }}">
                             <a href="{{ url($url . '/report/brand') }}">Brands</a>
                         </li> --}}
                     @endif
                 </ul>
             </li>
             <li class="nav-item dropdown">
                 <a class="dropdown-toggle" href="javascript:void(0);">
                     <span class="icon-holder">
                         <i class="anticon anticon-setting"></i>
                     </span>
                     <span class="title">Settings</span>
                     <span class="arrow">
                         <i class="arrow-icon"></i>
                     </span>
                 </a>
                 <ul class="dropdown-menu">
                     @if ($url == 'admin')
                         <li class="{{ request()->is($url . '/settings/app') ? 'active' : '' }}">
                             <a href="{{ url($url . '/settings/app') }}">APP Settings</a>
                         </li>
                     @endif
                     <li class="{{ request()->is($url . '/settings/user') ? 'active' : '' }}">
                         <a href="{{ url($url . '/settings/user') }}">User Settings</a>
                     </li>
                 </ul>
             </li>
         </ul>
     </div>
 </div>
 <!-- Side Nav END -->
