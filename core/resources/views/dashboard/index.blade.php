@extends('dashboard.partials.app')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="m-b-0 text-muted">Sales this month</p>
                                        <h2 class="m-b-0">{{ nb($info['sale']) }}</h2>
                                    </div>
                                    <span
                                        class="badge badge-pill  @if ($info['percentSuccessInfo']) badge-cyan
                                    @else
                                        badge-red @endif font-size-12">
                                        @if ($info['percentSale'] == 0)
                                            ~
                                        @elseif($info['percentSale'] > 0)
                                            <i class="anticon anticon-arrow-up"></i>
                                        @elseif($info['percentSale'] < 0)
                                            <i class="anticon anticon-arrow-down"></i>
                                        @endif
                                        <span class="font-weight-semibold m-l-5">{{ abs($info['percentSale']) }}%</span>
                                    </span>
                                </div>
                                <div class="m-t-40">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-primary badge-dot m-r-10"></span>
                                            <span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
                                        </div>
                                        <span class="text-dark font-weight-semibold font-size-13"> </span>
                                    </div>
                                    <div class="progress progress-sm w-100 m-b-0 m-t-10">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="m-b-0 text-muted">Rejected Orders</p>
                                        <h2 class="m-b-0">{{ nb($info['reject']) }}</h2>
                                    </div>
                                    <span
                                        class="badge badge-pill @if ($info['percentRejectInfo']) badge-cyan
                                    @else
                                        badge-red @endif font-size-12">
                                        @if ($info['percentReject'] == 0)
                                            ~
                                        @elseif($info['percentReject'] > 0)
                                            <i class="anticon anticon-arrow-up"></i>
                                        @elseif($info['percentReject'] < 0)
                                            <i class="anticon anticon-arrow-down"></i>
                                        @endif
                                        <span class="font-weight-semibold m-l-5">{{ abs($info['percentReject']) }}%</span>
                                    </span>
                                </div>
                                <div class="m-t-40">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-success badge-dot m-r-10"></span>
                                            <span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
                                        </div>
                                        <span class="text-dark font-weight-semibold font-size-13"></span>
                                    </div>
                                    <div class="progress progress-sm w-100 m-b-0 m-t-10">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="m-b-0 text-muted">Total Customer</p>
                                        <h2 class="m-b-0">{{ $info['customer'] }}</h2>
                                    </div>
                                    {{-- <span class="badge badge-pill badge-red font-size-12">
                                        <i class="anticon anticon-arrow-down"></i>
                                        <span class="font-weight-semibold m-l-5">2.71%</span>
                                    </span> --}}
                                </div>
                                <div class="m-t-40">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-warning badge-dot m-r-10"></span>
                                            <span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
                                        </div>
                                        <span class="text-dark font-weight-semibold font-size-13"> </span>
                                    </div>
                                    <div class="progress progress-sm w-100 m-b-0 m-t-10">
                                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="m-b-0 text-muted">Active Product</p>
                                        <h2 class="m-b-0">{{ $info['product'] }}</h2>
                                    </div>
                                    {{-- <span class="badge badge-pill badge-gold font-size-12">
                                        <i class="anticon anticon-arrow-up"></i>
                                        <span class="font-weight-semibold m-l-5">N/A</span>
                                    </span> --}}
                                </div>
                                <div class="m-t-40">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-secondary badge-dot m-r-10"></span>
                                            <span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
                                        </div>
                                        <span class="text-dark font-weight-semibold font-size-13"> </span>
                                    </div>
                                    <div class="progress progress-sm w-100 m-b-0 m-t-10">
                                        <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Recent Transaction</h5>
                            <div>
                                <a href="{{ url(auth()->user()->role . '/report/selling') }}"
                                    class="btn btn-sm btn-default">View All</a>
                            </div>
                        </div>
                        <div class="m-t-30">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($table as $item)
                                            <tr>
                                                <td>#{{ $item->Invoice }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-image"
                                                                style="height: 30px; min-width: 30px; max-width:30px">

                                                                {!! userIMG($item->customer) !!}
                                                            </div>
                                                            <h6 class="m-l-10 m-b-0">{{ $item->customers->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ dates($item->created_at) }}</td>
                                                <td>{{ nb($item->amount) }}</td>
                                                <td>
                                                    {!! $item->status() !!}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Data</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- page js -->
    <script src="{{ asset('app') }}/assets/vendors/chartjs/Chart.min.js"></script>
    <script src="{{ asset('app') }}/assets/js/pages/dashboard-e-commerce.js"></script>
@endpush
