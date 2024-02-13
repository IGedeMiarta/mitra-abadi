 <!-- Special offer -->
 <div class="discounts-wrap">
     <h3 class="component-ttl"><span>Special offer</span></h3>
     <div class="flexslider discounts-list">
         <ul class="slides">

             @foreach ($special as $s)
                 <li class="discounts-i">
                     <a href="{{ url('product/' . $s->product->product_slug . '?special=1') }}" class="discounts-i-img">
                         <img src="{{ $s->product->images() }}" alt="Dicta doloremque">
                     </a>
                     <h3 class="discounts-i-ttl">
                         <a
                             href="{{ url('product/' . $s->product->product_slug . '?special=1') }}">{{ $s->product->product_name }}</a>
                     </h3>
                     <p class="discounts-i-price">
                         <del>Rp {{ number_format($s->product->price, 0, '.', ',') }}</del>
                         <b class="text-primary">Rp {{ number_format($s->final_amount, 0, '.', ',') }}</b>
                     </p>
                 </li>
             @endforeach
         </ul>
     </div>
     <div class="discounts-info">
         <p>Special offer!<br>Limited time only</p>
         <a href="{{ url('special-catalog') }}">Shop now</a>
     </div>
 </div>
