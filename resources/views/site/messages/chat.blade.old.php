@extends('layouts.site-dash')
@section('title', 'محادثة مع ' . 'الدعم')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">مراسلة الدعم</h5>
        </div>
        <div class="card-body" style="max-height: 500px; overflow-y: auto;">
            @foreach ($messages as $msg)
                @if ($msg->sender_id === auth()->id())
                    <div style="justify-self: start;"
                        class="mb-3 d-flex {{ $msg->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                        <div
                            class="d-inline-block p-2 rounded bg-{{ $msg->sender_id === auth()->id() ? 'primary text-white' : 'light' }}">
                            @if ($msg->title)
                                <strong>{{ $msg->title }}</strong><br>
                            @endif
                            {{ $msg->body }}<br>
                            <small class="text-muted">{{ $msg->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @else
                    <div class="mb-3 {{ $msg->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                        <div
                            class="d-inline-block p-2 rounded bg-{{ $msg->sender_id === auth()->id() ? 'primary text-white' : 'light' }}">
                            @if ($msg->title)
                                <strong>{{ $msg->title }}</strong><br>
                            @endif
                            {{ $msg->body }}<br>
                            <small class="text-muted">{{ $msg->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="card-footer">
            <form method="POST" action="{{ route('site.messages.send') }}">
                @csrf

                <div class="mb-2">
                    <input type="text" name="title" class="form-control" placeholder="عنوان الرسالة (اختياري)">
                </div>

                <div class="mb-2">
                    <textarea name="body" class="form-control" rows="3" placeholder="محتوى الرسالة" required></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-25">إرسال</button>
                </div>
            </form>
        </div>
    </div>
@endsection
