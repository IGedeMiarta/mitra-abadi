@extends('dashboard.partials.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>All {{ $title ?? '' }}</h4>
            <div>
                <div class="table-responsive">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($table as $t)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="{{ url($t->images) }}" alt="{{ $t->product_slug }}"
                                                    style="max-width: 100px">
                                            </div>
                                            <div class="col-md-8 p-3">
                                                <b>Name :</b> {{ $t->product_name }} <br>
                                                <b>Brand :</b> {{ $t->brand->name }} <br>
                                                <b>Category :</b> {{ $t->category->category_name }} <br>
                                                <b>In size :</b> {{ $t->in_size }} <br>
                                                <b>Out Size :</b> {{ $t->out_size }} <br>
                                                <b>Weight :</b> {{ $t->weight }} <br>
                                                <b>Price : </b> Rp {{ number_format($t->price, 0, '.', ',') }} <br>

                                                @if ($t->status)
                                                    <span class="badge badge-success">ACTIVE</span>
                                                @else
                                                    <span class="badge badge-danger">NONACTIVE</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $t->stock }}</td>
                                    <td>

                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-info btn-sm mb-2 btnSee" data-toggle="modal"
                                            data-target="#modalSee" data-id="{{ $t->id }}">
                                            <i class="anticon anticon-eye mr-2"></i>
                                            SEE LOG
                                        </button>
                                        <button class="btn btn-warning btn-sm btnEdit mb-2"
                                            data-url="{{ url('admin/products', $t->id) }}" data-id="{{ $t->id }}"
                                            data-details="{{ $t->description }}" data-slug="{{ $t->product_slug }}"
                                            data-name="{{ $t->product_name }}" data-image="{{ url($t->images) }}"
                                            data-in_size="{{ $t->in_size }}" data-brand="{{ $t->brand_id }}"
                                            data-out_size="{{ $t->out_size }}" data-category="{{ $t->id_category }}"
                                            data-weight="{{ $t->weight }}"
                                            data-price="{{ number_format($t->price, 0, '.', ',') }}"
                                            data-status="{{ $t->status }}"><i class="anticon anticon-edit mr-2"></i>
                                            EDIT STOK</button>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
                    <button type="button" class="close" onclick="hideEditModal()" data-dismiss="modal">
                        <i class="anticon anticon-close" class="close"></i>
                    </button>
                </div>
                <form action="{{ url('update-stock') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Product</label>
                            <div class="col-sm-10">
                                <select name="" id="productSelected" class="form-control" disabled>
                                    <option disabled>-Select</option>
                                    @foreach ($editproducts as $item)
                                        <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                            {{ $item->product_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">cannot edit product</span>
                            </div>
                        </div>
                        <input type="hidden" name="product" id="productId">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-10">
                                <select name="type" class="form-control">
                                    <option disabled>type</option>
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Stock</label>
                            <div class="col-sm-10">
                                <input type="number" name="stock" id="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Notes</label>
                            <div class="col-sm-10">
                                <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
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
    <!-- Modal See-->
    <div class="modal fade" id="modalSee">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Details Product</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="hideSeeModal()"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Start </th>
                                    <th>End </th>
                                    <th>Notes</th>
                                    <th>By</th>

                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('.close').on('click', function() {
            $(this).modal('hide');
        })

        function hideEditModal() {
            $('#modalEdit').modal('hide');
        }

        function hideSeeModal() {
            $('#modalSee').modal('hide');
        }

        $('.btnEdit').on('click', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const id = $(this).data('id');
            console.log(id);
            $('#productId').val(id);
            $('#productSelected').val(id);
            $('#modalEdit').modal('show');
        })
        $('.btnSee').on('click', function() {
            const id = $(this).data('id');
            $.ajax({
                url: "{{ url('stock-log') }}" + "/" + id,
                success: function(result) {
                    $('#tbody').html(result.table)
                }
            });

        })
    </script>
@endpush
