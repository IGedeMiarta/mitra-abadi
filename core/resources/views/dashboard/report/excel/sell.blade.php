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
                  <center>
                      <b>
                          <h2>All Selling</h2>
                      </b>
                  </center>
              </th>
          </tr>
          <tr>
              <th colspan="6"></th>
          </tr>
      </thead>
      <thead>
          <tr>
              <th>Date</th>
              <th>Status</th>
              <th>Notes</th>
              <th>TRX</th>
              <th>Customer</th>
              <th>Amount</th>
          </tr>
      </thead>
      <tbody>
          @php
              $total_aprove = 0;
          @endphp
          @foreach ($table as $t)
              @php
                  $total_aprove += $t->status == 2 ? $t->amount : 0;
              @endphp

              <tr>
                  <td>
                      <span style="color: gray"> {{ dt($t->created_at) }}</span>
                  </td>
                  <td>{!! $t->status() !!}</td>
                  <td>{{ $t->info }}</td>
                  <td>{{ $t->Invoice }}</td>
                  <td>{{ $t->customers->name }}</td>
                  <td>{{ $t->amount }}</td>
              </tr>
          @endforeach
      </tbody>
      @if ($table->count() > 0)
          <tfoot>
              <tr style="background-color: #F3EEEA">
                  <td colspan="5" style="text-align: end">Total Approve</td>
                  <td>{{ $total_aprove ?? 0 }}</td>
              </tr>
          </tfoot>
      @endif
  </table>
