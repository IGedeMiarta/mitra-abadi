 <ul class="b-crumbs">
     <li>
         <a href="{{ url('/') }}">
             Home
         </a>
     </li>
     @stack('partials.add')
     <li>
         <span>{{ $title ?? '' }}</span>
     </li>
 </ul>
