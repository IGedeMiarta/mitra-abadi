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
                <div class="col-md-4">
                    <label>Filer By:</label>
                    <select name="" id="filter" class="form-control">
                        <option value="all" @if ($filter == 'all') selected @endif>All</option>
                        <option value="daily" @if ($filter == 'daily') selected @endif>Daily</option>
                        <option value="weekly" @if ($filter == 'weekly') selected @endif>Weekly</option>
                        <option value="monthly" @if ($filter == 'monthly') selected @endif>Monthly</option>
                        <option value="year" @if ($filter == 'year') selected @endif>Year</option>
                    </select>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4 mt-4">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active" @disabled(true)>
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Export As:
                            </label>
                            <label class="btn btn-danger " id="btnPDF">
                                <i class="anticon anticon-file-pdf"></i> PDF
                            </label>
                            <label class="btn btn-success" id="btnExcel">
                                <i class="anticon anticon-file-excel"></i> Excel
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <hr>
            <div class="table-responsive" id="myTable">
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>TRX</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_aprove = 0;
                        @endphp
                        @foreach ($table as $t)
                            @php
                                $total_aprove += $t->status == 2 ? $t->amount : $t->dp;
                            @endphp

                            <tr>
                                <td>
                                    <span style="color: gray"> {{ dt($t->created_at) }} <br> {!! $t->status() !!}</span>
                                </td>
                                <td>{!! $t->info ?? '<i style="color: gray">noInfo</i>' !!}</td>
                                <td>{{ $t->Invoice }}</td>
                                <td>
                                    <a href="#">{{ $t->customers->name }}</a>
                                    <br>
                                    {{ $t->customers->phone }}
                                    <br>
                                    {{ $t->customers->address }}

                                </td>
                                <td class="text-end" style="width: 20%">
                                    <span> {{ num($t->amount) }}</span>
                                    @if ($t->dp > 0)
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
                    @if ($table->count() > 0)
                        <tfoot>
                            <tr style="background-color: #F3EEEA">
                                <td colspan="4" style="text-align: end">Total Approve</td>
                                <td>{{ nb($total_aprove ?? 0) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>

            </div>

        </div>
    </div>
@endsection
@push('script')
    <!-- page js -->
    <script src="{{ asset('app') }}/assets/vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('app') }}/assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#data-table').DataTable();
        let filter = "{{ $_GET['filter'] ?? 'all' }}";
        $('#filter').on('change', function(e) {
            const filter = $(this).val();
            const url = "{{ Request::url() }}?filter=" + filter;
            window.location.href = url;
        })
        $('#btnPDF').on('click', function(e) {
            const url = "{{ route('admin.report.pdf', 'sell') }}?filter=" + filter;
            window.open(url, '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            const url = "{{ route('admin.report.excel', 'sell') }}";
            window.open(url);
        });
    </script>
@endpush
