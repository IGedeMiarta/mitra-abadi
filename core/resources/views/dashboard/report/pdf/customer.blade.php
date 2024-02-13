@extends('dashboard.report.pdf.master')
@section('content')
    <table id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $t)
                <tr>
                    <td>{{ $t->email }} <br>{{ $t->name }}</td>
                    <td>{{ $t->phone }}</td>
                    <td>{{ $t->address }}</td>
                    <td>{!! status($t->status) !!}</td>
                    <td>{{ dt($t->created_at) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
