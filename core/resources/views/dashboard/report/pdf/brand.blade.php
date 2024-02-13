@extends('dashboard.report.pdf.master')
@section('content')
    <table id="myTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->name }}</td>
                    <td>{{ dt($t->created_at) }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
