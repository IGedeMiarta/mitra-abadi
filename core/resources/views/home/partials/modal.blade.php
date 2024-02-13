 <!-- Quick View Product - start -->
 <div class="qview-modal">
     <div class="prod-wrap">
         <a href="product.html">
             <h1 class="main-ttl">
                 <span id="categoryText">Template Details</span>
             </h1>
         </a>
         <div class="prod-slider-wrap">
             <div class="prod-slider" id="imgSlider">
             </div>

         </div>
         <div class="prod-cont">
             <h1 class="mt-n5">
                 <h2 id="productName"></h2>
             </h1>
             <div class="prod-info mb-5 row" style="margin-bottom: 10px">
                 <div class="col-md-12">
                     <p class="prod-skuttl">Brand</p>
                     <a href="" id="authorUrl">
                         <h3 class="item_current_price badge badge-dark"
                             style="background-color: blue; border-radius: 0%" id="authorName"></h3>
                     </a>
                 </div>
             </div>
             <div class="prod-info row mb-5" style="margin-top: 20px">
                 <div class="col-lg-4 col-md-12 col-sm-12" style="margin-top:20px">
                     <p class="prod-skuttl">Inner Size</p>
                     <h3 class="item_current_price badge badge-primary "
                         style="background-color: gray; border-radius: 0%" id="in_size">
                         0x0x0 mm</h3>
                 </div>
                 <div class="col-lg-4 col-md-12 col-sm-12" style="margin-top:20px">
                     <p class="prod-skuttl">Outer Size</p>
                     <h3 class="item_current_price badge badge-primary "
                         style="background-color: gray; border-radius: 0%" id="out_size">
                         0x0x0 mm</h3>
                 </div>
                 <div class="col-lg-4 col-md-12 col-sm-12" style="margin-top:20px">
                     <p class="prod-skuttl">Wight</p>
                     <h3 class="item_current_price badge badge-primary "
                         style="background-color: gray; border-radius: 0%" id="weight">
                         00 Kg</h3>
                 </div>
             </div>
             <div class="prod-info" style="margin-top: 30px">

                 <p class="prod-price">
                     <del class="disc">Rp 00,000</del>
                     <b class="item_current_price" id="price">Rp 00,000</b>
                 </p>
                 <p class="prod-addwrap">
                     <a href="#" class="prod-add"><i class="fa fa-shopping-cart  mr-2"></i> Add to cart</a>
                 </p>
             </div>
             <ul class="prod-i-props">
                 <li>
                     <p class="detailsHire"></p>
                 </li>
                 {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem nulla fugiat odit neque sunt molestias,
                 error illum quas sint corrupti in, iure ipsa. Nulla omnis voluptas quibusdam recusandae velit, eius quo
                 repellendus expedita culpa dignissimos sapiente natus delectus quaerat quasi id temporibus amet
                 voluptatibus, autem minus nostrum sit officiis alias! Dolorum, sequi accusantium illo a quis asperiores
                 voluptas dolores autem odio mollitia labore vel! Quis eligendi dolores alias aspernatur ut possimus
                 quaerat iusto rerum, exercitationem veritatis dolor! Maxime quae quis officiis repellat facere, earum
                 quidem nesciunt ullam in placeat nam. Saepe nisi omnis maiores repudiandae suscipit rerum iure sit
                 voluptates. --}}
             </ul>
         </div>

     </div>
 </div>
 @push('script')
     <script>
         $('.btnDetails').on('click', function(e) {
             e.preventDefault();
             const id = $(this).data('id');
             const name = $(this).data('name');
             const price = $(this).data('price');
             const slug = $(this).data('slug');
             const category = $(this).data('category');
             const id_category = $(this).data('id_category');
             const tags = $(this).data('tags');
             const disc = $(this).data('disc');
             const desc = $(this).data('desc');
             var details = $(this).data('desc');
             const authorid = $(this).data('brandid');
             const authorname = $(this).data('brandname');
             const image = $(this).data('image');
             console.log(image);
             const in_size = $(this).data('in_size');
             const out_size = $(this).data('in_size');
             const weight = $(this).data('weight');

             $('.disc').html(number_format(disc));

             $('#authorUrl').attr('href', `catalog?brand=${authorid}`);
             $('#authorName').html(authorname);

             $('#productName').html(name);
             $('.showTags').html(tags);
             $('#price').html(number_format(price));
             details = details.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
             details = details.replace(/\n/g, '<br>');
             $('.detailsHire').html(details);
             let slide = ' <ul class="prod-slider-car">';
             slide += `<li class="float: left; list-style: none; position: relative; width: 464px;"><a data-fancybox-group="popup-product" class="fancy-img" href="${image}"  target="_blank">
                                                <img src="${image}" alt="">
                                            </a>
                                        </li>`;
             slide += '</ul>';
             $('#imgSlider').html(slide);

             if (disc == 0) {
                 $('.disc').css('display', 'none');
             }

             $('.prod-add').attr('href', `chart-add?_xcode=${price*111111}&product=${slug}`);
             $('#in_size').html(in_size + ' mm')
             $('#out_size').html(out_size + ' mm')
             $('#weight').html(weight + ' kg')
         })

         function number_format(number) {
             return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         }
     </script>
 @endpush
