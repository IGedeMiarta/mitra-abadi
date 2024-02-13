@extends('dashboard.partials.app')
@push('style')
    <!-- page css -->
    <link href="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
@endpush
@section('content')
    @php
        $url = auth()->user()->role;
    @endphp
    <button class="btn btn-success mb-3 text-end" data-toggle="modal" data-target="#modalAdd"><i
            class="anticon anticon-plus-square mr-2"></i>Add
        {{ $title }}</button>
    <div class="card">
        <div class="card-body">
            <h4>All {{ $title ?? '' }}</h4>
            <div>
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Created At</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->category_name }}</td>
                                <td>{{ $t->category_slug }}</td>
                                <td>{{ $t->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <form action="{{ url('admin/categories', $t->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-warning btn-sm mr-2 btnEdit" data-id="{{ $t->id }}"
                                            data-name="{{ $t->category_name }}"
                                            data-update="{{ url($url . '/categories') . '/' . $t->id }}"><i
                                                class="anticon anticon-edit"></i>
                                            Edit</button>
                                        <button type="submit" class="btn btn-danger btn-sm mr-2"><i
                                                class="anticon anticon-delete"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Add-->
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="category_name" placeholder="category name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form action="" method="POST" id="updateForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="category_name"
                                    placeholder="category name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- page js -->
    <script src="{{ asset('app') }}/assets/vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        const url = "{{ auth()->user()->role }}";
        $('#data-table').DataTable();
        $('.btnEdit').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const updateUrl = $(this).data('update');

            console.log(updateUrl);
            $('#modalEdit').modal('show');
            $('#name').val(name);
            $('#updateForm').attr('action', updateUrl);
        });
    </script>
@endpush
