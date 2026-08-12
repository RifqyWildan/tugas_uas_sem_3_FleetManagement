@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('page-title', 'Notifikasi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Semua Notifikasi</h3>
            <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-secondary">Tandai Semua Dibaca</button>
            </form>
        </div>
        <div class="card-body">
            @foreach($notifications as $note)
                <div class="mb-3 p-2 border rounded {{ is_null($note->read_at) ? 'bg-light' : '' }}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $note->data['title'] ?? 'Notifikasi' }}</strong>
                            <div class="text-muted">{{ $note->data['message'] ?? '' }}</div>
                        </div>
                        <div class="text-right text-muted">
                            <small>{{ $note->created_at->diffForHumans() }}</small>
                            @if(is_null($note->read_at))
                                <div><span class="badge badge-primary">Baru</span></div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.notifications.show', $note->id) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                    </div>
                </div>
            @endforeach

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection
