  <table id="myTable">
      <thead>
          <tr>
              <th colspan="9"></th>
          </tr>
          <tr>
              <th colspan="9"></th>
          </tr>
          <tr>
              <th colspan="9">
                  <center><b>
                          <h2>All Product</h2>
                      </b></center>
              </th>
          </tr>
          <tr>
              <th colspan="9"></th>
          </tr>
      </thead>
      <thead>
          <tr>
              <th>No</th>
              {{-- <th>Image</th> --}}
              <th>Name</th>
              <th>Brand</th>
              <th>Category</th>
              <th class="text-center">Outer Size <span class="small">(mm)</span></th>
              <th class="text-center">Inner Size <span class="small">(mm)</span></th>
              <th class="text-center">Weight <span class="small">(kg)</span></th>
              <th>Price</th>
              <th>Stock</th>
              <th>Status</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($table as $t)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  {{-- <td class="text-center">
                      <img src="{{ asset($t->images) }}" alt="{{ $t->product_slug }}" style="max-width: 100px">

                  </td> --}}
                  <td>{{ $t->product_name }}</td>
                  <td>{{ $t->brand->name }}</td>
                  <td>{{ $t->category->category_name }}</td>
                  <td>{{ $t->in_size }}</td>
                  <td>{{ $t->out_size }}</td>
                  <td>{{ $t->weight }}</td>
                  <td>{{ $t->price }}</td>
                  <td>{{ $t->stock }}</td>
                  <td>
                      {!! status($t->status) !!}
                  </td>

              </tr>
          @endforeach

      </tbody>
  </table>
