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
                          <h2>All Customer</h2>
                      </b></center>
              </th>
          </tr>
          <tr>
              <th colspan="6"></th>
          </tr>
      </thead>
      <thead>
          <tr>
              <th>Email</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Status</th>
              <th>Created At</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($table as $t)
              <tr>
                  <td>{{ $t->email }}</td>
                  <td>{{ $t->name }}</td>
                  <td>{{ $t->phone }}</td>
                  <td>{{ $t->address }}</td>
                  <td>{!! status($t->status) !!}</td>
                  <td>{{ dt($t->created_at) }}</td>
              </tr>
          @endforeach

      </tbody>
  </table>
