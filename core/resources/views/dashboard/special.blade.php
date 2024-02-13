@extends('dashboard.partials.app')
@push('style')
    <!-- page css -->
    <link href="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .bg-grey {
            background-color: #c0c5ce
        }
    </style>
@endpush
@section('content')
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
                            <th>Disc</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $t)
                            <tr style="@if (!$t->status) background-color:#F2F1EB @endif">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->product->product_name }}</td>
                                <td>{{ $t->disc }}%</td>
                                <td>
                                    <small> <del
                                            class="text-danger">{{ number_format($t->product->price, 0, '.', ',') }}</del>
                                    </small><br>
                                    {{ number_format($t->final_amount, 0, '.', ',') }}
                                </td>
                                <td>{!! status($t->status) !!}</td>
                                <td class="text-center">
                                    <form action="/admin/special-products/{{ $t->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-warning btn-sm mr-2 btnEdit"
                                            data-id="{{ $t->id }}" data-disc="{{ $t->disc }}"
                                            data-price="{{ $t->product->price }}" data-finn="{{ $t->final_amount }}"
                                            data-status="{{ $t->status }}" data-toggle="modal"
                                            data-target="#modalEdit"><i class="anticon anticon-edit"></i>
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
                            <label for="name" class="col-sm-2 col-form-label">Product</label>
                            <div class="col-sm-10">
                                <select name="product" id="productSelected" class="select2">
                                    <option selected disabled>-Select</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                            {{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control price" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Disc(%)</label>
                            <div class="col-sm-10">
                                <input type="text" name="disc" class="form-control disc">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Final Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="final" class="form-control finn">
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
                            <label for="name" class="col-sm-2 col-form-label">Product</label>
                            <div class="col-sm-10">
                                <select name="product" id="productSelected" class="form-control" disabled>
                                    <option disabled>-Select</option>
                                    @foreach ($editproducts as $item)
                                        <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                            {{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">cannot edit product</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" id="price" disabled>
                                <span class="text-danger">cannot edit product default price</span>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Disc(%)</label>
                            <div class="col-sm-10">
                                <input type="text" name="disc" id="disc" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Final Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="final" class="form-control finn" id="finn">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Disable</option>
                                </select>
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
    {{-- select 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

        });
    </script>
    <script>
        $('#data-table').DataTable();
        $('.btnEdit').on('click', function(e) {
            const id = $(this).data('id');
            const disc = $(this).data('disc');
            const price = $(this).data('price');
            const finn = $(this).data('finn');
            const status = $(this).data('status');

            $('#price').val(numbers(price));
            $('#disc').val(disc);
            $('#finn').val(finn);
            $('#status').val(status);
            let url = "{{ url('admin/special-products') }}" + "/" + id;
            $('#updateForm').attr('action', url);
        })
        $('#productSelected').on('change', function() {
            var selectedOption = $(this).find(':selected');

            // Get the data-price attribute value
            var price = selectedOption.data('price');

            $('.price').val(numbers(price));
        })
        $('.disc').on('keyup', function() {
            const price = toInt($('.price').val());
            const disc = toInt($(this).val());
            var discon = price * disc / 100;
            var fin = price - discon;
            $('.finn').val(numbers(fin));
        });
        $('#disc').on('keyup', function() {
            const price = toInt($('#price').val());
            const disc = toInt($(this).val());
            var discon = price * disc / 100;
            var fin = price - discon;
            $('.finn').val(numbers(fin));
        });


        function numbers(input) {
            return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function toInt(input) {

            let inp = input.replace(/,/g, '');
            return parseInt(inp)
        }
    </script>
@endpush
