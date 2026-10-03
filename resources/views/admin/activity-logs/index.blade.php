@extends('admin.layout')
@section('title', 'Activity logs')
@section('content')
<h1>Activity logs</h1>
<table>
    <thead><tr><th>When</th><th>User</th><th>Action</th><th>Subject</th></tr></thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->user?->email ?? '—' }}</td>
            <td>{{ $log->action }}</td>
            <td>{{ $log->subject_type }} #{{ $log->subject_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $logs->links() }}
@endsection
