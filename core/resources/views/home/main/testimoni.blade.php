   <!-- Testimonials -->
   <div class="reviews-wrap">
       <h5 class="text-center"><span>Testimonials</span></h5>
       <div class="reviewscar-wrap">
           <div class="swiper-container reviewscar">
               <div class="swiper-wrapper">
                   @foreach ($testi as $txt)
                       <div class="swiper-slide">
                           <p>{{ $txt->text }}</p>
                       </div>
                   @endforeach
               </div>
           </div>
           <div class="swiper-container reviewscar-thumbs">
               <div class="swiper-wrapper">
                   @foreach ($testi as $i => $tst)
                       <div class="swiper-slide">
                           <img src="{{ asset('ava/' . $i % 10 . '.jpg') }}" class="prod-i-img"
                               alt="{{ $tst->user->name }}">
                           <h3 class="reviewscar-ttl"><a href="reviews.html">{{ $tst->user->name }}</a></h3>
                           <p class="reviewscar-post">{{ $tst->roles }}</p>
                       </div>
                   @endforeach
               </div>
           </div>
       </div>
   </div>
