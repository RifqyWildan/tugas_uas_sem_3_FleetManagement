@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('page-title', 'Notifikasi')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>{{ $notification->data['title'] ?? 'Notifikasi' }}</h4>
            <p>{{ $notification->data['message'] ?? '' }}</p>
            <p class="text-muted">Diterima: {{ $notification->created_at->toDayDateTimeString() }}</p>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
