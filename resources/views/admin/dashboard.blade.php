@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<h1>Dashboard</h1>
<ul>
    <li>Pages: {{ $stats['pages'] }}</li>
    <li>New bookings: {{ $stats['bookings_new'] }} / {{ $stats['bookings_total'] }} total</li>
    <li>New enquiries: {{ $stats['enquiries_new'] }}</li>
    <li>Pending reviews: {{ $stats['reviews_pending'] }}</li>
</ul>
<h2>Recent bookings</h2>
<table>
    <thead><tr><th>Ref</th><th>Name</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
    @forelse($recentBookings as $b)
        <tr>
            <td><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_reference }}</a></td>
            <td>{{ $b->name }}</td>
            <td>{{ $b->status }}</td>
            <td>{{ $b->created_at?->format('d M Y') }}</td>
        </tr>
    @empty
        <tr><td colspan="4">No bookings yet.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
