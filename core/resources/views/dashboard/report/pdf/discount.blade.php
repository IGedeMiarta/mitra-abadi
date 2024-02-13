@extends('dashboard.report.pdf.master')
@section('content')
    <table id="myTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Disc</th>
                <th>Last Price</th>
                <th>Final Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->product->product_name }}</td>
                    <td>{{ $t->disc }}%</td>
                    <td>
                        {{ nb($t->product->price) }}
                    </td>
                    <td> {{ nb($t->final_amount) }}</td>
                    <td>{!! status($t->status) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
