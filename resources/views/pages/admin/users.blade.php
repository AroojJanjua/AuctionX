@extends('layouts.app')
@section('title', 'Manage Users By Admin')
@section('content')
 
<div class="page-header">
  <div class="container">
    <h2>Manage Users</h2>
    <p>{{ $users->total() }} registered users</p>
  </div>
</div>

<div class="container py-4">
    {{-- filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2 flex-wrap mb-4">
    <input type="text" name="search" class="form-control-ax" style="max-width:280px"
           placeholder="Search name or email..." value="{{ request('search') }}" />
    <select name="role" class="form-select-ax" style="width:auto" onchange="this.form.submit()">
      <option value="">Roles</option>
      <option value="bidder"  {{ request('role')==='bidder'  ? 'selected':'' }}>Bidders</option>
      <option value="seller"  {{ request('role')==='seller'  ? 'selected':'' }}>Sellers</option>
      <option value="admin"   {{ request('role')==='admin'   ? 'selected':'' }}>Admins</option>
    </select>
    <button type="submit" class="btn btn-brown px-3"><i class="bi bi-search me-1"></i></button>
    @if(request()->anyFilled(['search','role']))
      <a href="{{ route('admin.users.index') }}" class="btn btn-ghost-ax px-3">Clear</a>
    @endif
  </form>

  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="table-responsive">
      <table class="table mb-0" style="font-size:.88rem">
        <thead style="background:var(--surface)">
          <tr>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">User</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Role</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Bids</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Listings</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Joined</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Status</th>
            <th style="font-weight:700;color:var(--muted);border:none;padding:11px 16px">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
          <tr style="border-bottom:1px solid var(--border)">
          <td style="padding:12px 16px;vertical-align:middle">
              <div class="d-flex align-items-center gap-2">
                <div style="width:34px;height:34px;border-radius:50%;background:var(--br-pale);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;color:var(--br);flex-shrink:0">
                  {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                  <div style="font-weight:700">{{ $user->name }}</div>
                  <div style="font-size:.75rem;color:var(--muted)">{{ $user->email }}</div>
                </div>
              </div>
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <form method="POST" action="{{ route('admin.users.role', $user->id) }}">
                @csrf @method('PUT')
                <select name="role" class="form-select-ax" style="width:auto;font-size:.78rem"
                        onchange="this.form.submit()" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                  @foreach(['bidder','seller','admin'] as $role)
                    <option value="{{ $role }}" {{ $user->role === $role ? 'selected':'' }}>{{ ucfirst($role) }}</option>
                  @endforeach
                </select>
              </form>
            </td>
            <td style="padding:12px 16px;vertical-align:middle;color:var(--muted)">{{ $user->bids_count }}</td>
            <td style="padding:12px 16px;vertical-align:middle;color:var(--muted)">{{ $user->auctions_count }}</td>
            <td style="padding:12px 16px;vertical-align:middle;color:var(--muted);font-size:.8rem">{{ $user->created_at->format('M d, Y') }}</td>
            <td style="padding:12px 16px;vertical-align:middle">
              @if($user->is_banned)
                <span class="badge rounded-pill badge-closed">Banned</span>
              @else
                <span class="badge rounded-pill badge-timed">Active</span>
              @endif
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <div class="d-flex gap-1">
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-ghost-ax btn-sm" title="View"><i class="bi bi-eye"></i></a>
                @if($user->id !== auth()->id())
                  <form method="POST" action="{{ route('admin.users.ban', $user->id) }}">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-sm"
                            style="background:{{ $user->is_banned ? 'var(--green-bg)' : 'var(--red-bg)' }};
                            color:{{ $user->is_banned ? 'var(--green)' : 'var(--red)' }};
                            border:1px solid {{ $user->is_banned ? 'var(--green-bd)' : 'var(--red-bd)' }}"
                            title="{{ $user->is_banned ? 'Unban' : 'Ban' }}">
                      <i class="bi {{ $user->is_banned ? 'bi-unlock' : 'bi-lock' }}"></i>
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                        onsubmit="return confirm('Delete {{ $user->name }} permanently? This cannot be undone.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm"
                            style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)"
                            title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center py-4" style="color:var(--muted)">No users found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 d-flex justify-content-center">
      {{ $users->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
  </div>
</div>
@endsection