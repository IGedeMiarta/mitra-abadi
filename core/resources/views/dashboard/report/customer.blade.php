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
            <hr>
            <div class="table-responsive" id="myTable">
                <table id="data-table" class="table nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
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
                                <td>{{ $loop->iteration }}</td>
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
        $('#btnPDF').on('click', function(e) {
            const url = "{{ route('admin.report.pdf', 'customer') }}";
            window.open(url, '_blank');
        });
        $('#btnExcel').on('click', function(e) {
            const url = "{{ route('admin.report.excel', 'customer') }}";
            window.open(url);
        });
    </script>
@endpush
