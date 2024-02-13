  <table id="myTable">
      <thead>
          <tr>
              <th colspan="4"></th>
          </tr>
          <tr>
              <th colspan="4"></th>
          </tr>
          <tr>
              <th colspan="4">
                  <center><b>
                          <h2>All Category</h2>
                      </b></center>
              </th>
          </tr>
          <tr>
              <th colspan="4"></th>
          </tr>
      </thead>
      <thead>
          <tr>
              <th>No</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Created At</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($table as $t)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $t->category_name }}</td>
                  <td>{{ $t->category_slug }}</td>
                  <td>{{ dt($t->created_at) }}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
