  <table id="myTable">
      <thead>
          <tr>
              <th colspan="6"></th>
          </tr>
          <tr>
              <th colspan="6"></th>
          </tr>
          <tr>
              <th colspan="6">
                  <center><b>
                          <h2>All Discount</h2>
                      </b></center>
              </th>
          </tr>
          <tr>
              <th colspan="6"></th>
          </tr>
      </thead>
      <thead>
          <tr>
              <th>No</th>
              <th>Name</th>
              <th>Disc</th>
              <th>Last Price</th>
              <th>Final Price</th>
              <th>Status</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($table as $t)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $t->product->product_name }}</td>
                  <td>{{ $t->disc }}%</td>
                  <td>
                      {{ $t->product->price }}
                  </td>
                  <td> {{ $t->final_amount }}</td>
                  <td>{!! status($t->status) !!}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
