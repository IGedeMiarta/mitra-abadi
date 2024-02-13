@extends('dashboard.report.pdf.master')
@section('content')
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
@endsection
