@extends('admin.layouts.app')

@section('title', 'Admin Chat')

@section('content')
    <div class="container py-6">
        <h1 class="mb-4">Chat</h1>

        <p class="mb-3 text-muted">This is a lightweight chat placeholder. Replace with your real chat UI later.</p>

        <div class="card">
            <div class="card-body">
                <div id="chat-box" style="min-height:200px;border:1px solid #e5e7eb;padding:12px;background:#fff;">
                    <p class="text-muted">No messages yet.</p>
                </div>

                <form id="chat-form" class="mt-3" onsubmit="event.preventDefault(); alert('Replace with real chat send');">
                    <div class="input-group">
                        <input id="chat-input" type="text" class="form-control" placeholder="Type a message..." />
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
