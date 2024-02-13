 <!-- Related Products - start -->
 <div class="prod-related">
     <h2><span>Related products</span></h2>

     <div class="prod-related-car" id="prod-related-car">
         <ul class="slides">
             <li class="prod-rel-wrap">
                 @foreach ($related as $rel)
                     <div class="prod-rel">
                         <a href="{{ url('product/' . $rel->product_slug) }}" class="prod-rel-img">
                             <img src="{{ url($rel->images) }}" alt="Adipisci aperiam commodi">
                         </a>
                         <div class="prod-rel-cont">
                             <h3><a href="{{ url('product/' . $rel->product_slug) }}">{{ $rel->product_name }}</a></h3>
                             <p class="prod-rel-price">
                                 <b class="text-info">Rp {{ number_format($rel->price, 0, ',', '.') }}</b>
                             </p>
                         </div>
                     </div>
                 @endforeach
             </li>
         </ul>
     </div>

 </div>
 <!-- Related Products - end -->
