  <table id="myTable">
      <thead>
          <tr>
              <th colspan="3"></th>
          </tr>
          <tr>
              <th colspan="3"></th>
          </tr>
          <tr>
              <th colspan="3">
                  <center><b>
                          <h2>All Brand</h2>
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
              <th>Created At</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($table as $t)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $t->name }}</td>
                  <td>{{ dt($t->created_at) }}</td>
              </tr>
          @endforeach

      </tbody>
  </table>
