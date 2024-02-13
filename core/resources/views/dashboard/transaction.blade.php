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
    @php
        $filter = $_GET['filter'] ?? 'all';
    @endphp
    <div class="card">
        <div class="card-body">
            <h4>All {{ $title ?? '' }}</h4>
            <hr>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Filer By:</label>
                    <select name="" id="filter" class="form-control">
                        <option value="all" @if ($filter == 'all') selected @endif>All</option>
                        <option value="daily" @if ($filter == 'daily') selected @endif>Daily</option>
                        <option value="weekly" @if ($filter == 'weekly') selected @endif>Weekly</option>
                        <option value="monthly" @if ($filter == 'monthly') selected @endif>Monthly</option>
                        <option value="year" @if ($filter == 'year') selected @endif>Year</option>
                    </select>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">

                </div>

            </div>
            <hr>
            <div class="table-responsive ">
                <table id="data-table" class="table nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TRX</th>
                            <th>Customer</th>
                            <th>Total Price</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $t)
                            <tr>
                                <td>
                                    {{-- @if ($t->status != 5) --}}
                                    <button class="btn btn-info btn-sm btnUpdate" data-id="{{ $t->id }}"
                                        data-info="{{ $t->info }}" data-status="{{ $t->status }}"
                                        data-toggle="modal" data-target="#modalEdit" data-dp="{{ $t->dp }}"
                                        data-shipment="{{ $t->shipment }}"
                                        data-images="{{ $t->trx_img_1 === null ? 'https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg' : url('assets/' . $t->trx_img_1) }}"
                                        data-images2="{{ $t->trx_img_2 === null ? 'https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg' : url('assets/' . $t->trx_img_2) }}"><i
                                            class="fas fa-edit"></i>
                                    </button>
                                    {{-- @endif --}}
                                </td>
                                <td>
                                    <a href="{{ url('invoice/' . $t->Invoice) }}" target="_blank">{{ $t->Invoice }}</a>
                                    <br>
                                    <span style="color: gray"> {{ dt($t->created_at) }}</span>
                                    <br>
                                    {!! $t->status() !!}
                                    <br>
                                    Shipment: {!! $t->shipment() !!}
                                </td>
                                <td>
                                    <a href="#">{{ $t->customers->name }}</a>
                                    <br>
                                    {{ $t->customers->phone }}
                                    <br>
                                    {{ $t->customers->address }}

                                </td>
                                <td class="text-end" style="width: 20%">
                                    <span> {{ num($t->amount) }}</span>
                                    @if ($t->dp > 0 && $t->status != 5)
                                        <br>
                                        <small style="color: grey"><b>DP:</b> {{ num($t->dp) }}</small>
                                        <br>
                                        <span class="text-danger">
                                            {{ $t->dp > 0 ? '-' . num($t->amount - $t->dp) : '' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="list-group">
                                        <table class="table table-bordered">
                                            @foreach ($t->details as $d)
                                                <tr>
                                                    <td>{{ $d->product->product_name }}.</td>
                                                    <td>{{ $d->qty }}</td>
                                                    <td>{{ '@' . nb($d->price) }}</td>
                                                    <td>{{ nb($d->total) }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </ul>
                                </td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update {{ $title ?? '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formUpdate">
                    @csrf
                    @method('PUT')
                    <div class="modal-body row">
                        <div class="col-md-4">
                            <div class="paymentImg">
                                <a href="" class="SeeImages" target="_blank">
                                    <img src="" alt="" id="SeeImages" style="max-width: 250px">
                                </a>
                                <h5>
                                    <center> Payment Images</center>
                                </h5>
                            </div>

                            <div id="fullPaymentIMG" class="mt-3 d-none">

                                <a href="" class="SeeImages2" target="_blank">
                                    <img src="" alt="" id="SeeImages2" style="max-width: 250px">
                                </a>
                                <h5>
                                    <center>Full Payment Images</center>
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Notes <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="info" class="form-control" id="info" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Payment Status<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="select2-tags form-select form-control" name="status" id="status">
                                        <option disabled>- Select Payment Status</option>
                                        <option value="1">WAIT FOR PAYMENT</option>
                                        <option value="3">PAYMENT REJECT</option>
                                        <option value="2">PAYMENT APPROVE (FULL PAYMENT)</option>
                                        <option value="4">WAIT FOR FULL PAYMENT</option>
                                        <option value="5">COMPLETED</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row d-none" id="dpINP">
                                <label for="name" class="col-sm-3 col-form-label">DP <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="numbers" class="form-control inpNumber" name="dp" id="dp"
                                        placeholder="00,000">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Shipment Status<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select class="select2-tags form-select form-control" name="shipment" id="shipment">
                                        <option disabled>- Select Shipment Status</option>
                                        <option value="0">WAITING</option>
                                        <option value="1">SEND</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        $('#data-table').DataTable();
        $('#filter').on('change', function(e) {
            const filter = $(this).val();
            const url = "{{ Request::url() }}?filter=" + filter;
            window.location.href = url;
        })
        $('.btnUpdate').on('click', function(e) {
            const id = $(this).data('id');
            const url = `{{ url('admin/transaction/${id}') }}`;
            $('#info').val($(this).data('info'))
            $('#status').val($(this).data('status'))
            $('#shipment').val($(this).data('shipment'))
            $('#dp').val($(this).data('dp'))
            $('#formUpdate').attr('action', url);
            $('#SeeImages').attr('src', $(this).data('images'))
            $('#SeeImages2').attr('src', $(this).data('images2'))
            if ($(this).data('dp') > 0) {
                $('.SeeImages').attr('href', $(this).data('images'))
                $('.SeeImages2').attr('href', $(this).data('images2'))
                $('#fullPaymentIMG').removeClass('d-none')
            }
            if ($(this).data('status') == 4) {
                $('#dpINP').removeClass('d-none');

            }
        });
        $('#status').on('change', function() {
            var status = $(this).val();
            if (status == 4) {
                $('#dpINP').removeClass('d-none');
            } else {
                $('#dpINP').addClass('d-none');
            }
            console.log(status);
        })
    </script>
@endpush
