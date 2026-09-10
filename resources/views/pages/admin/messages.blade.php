@extends('layouts.app')
@section('title', 'Contact Messages — Admin')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Contact Messages</h2>
  </div>
</div>

<div class="container py-4">
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">

    @if($messages->isEmpty())
      <div class="text-center py-5" style="color:var(--muted)">
        <i class="bi bi-envelope" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
        No messages yet
      </div>

    @else
      @foreach($messages as $msg)
      <div class="px-4 py-3 d-flex justify-content-between align-items-center gap-3" style="border-bottom:1px solid var(--border)">
        <div style="flex:1;min-width:0">
          <div class="d-flex align-items-center gap-2 mb-1">
            <span style="font-weight:700;font-size:.9rem">{{ $msg->subject }}</span>
            <span style="font-size:.75rem;color:var(--muted)">by {{ $msg->name }} ({{ $msg->email }}{{ $msg->phone ? ', ' . $msg->phone : '' }})</span>
          </div>
          <div style="font-size:.85rem;color:var(--text);margin-bottom:.3rem;white-space:pre-line">{{ $msg->message }}</div>
          <div style="font-size:.72rem;color:var(--muted)">{{ $msg->created_at->format('M d, Y g:ia') }}</div>
        </div>
        <div>
          <form method="POST" action="{{ route('admin.messages.destroy', $msg->id) }}" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button class="btn btn-ghost-ax btn-sm" style="color:var(--red)" title="Delete"><i class="bi bi-trash"></i></button>
          </form>
        </div>
      </div>
      @endforeach
    @endif
  </div>

  @if($messages->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $messages->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
  @endif

</div>
@endsection