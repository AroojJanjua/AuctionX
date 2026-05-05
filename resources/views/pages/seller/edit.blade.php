@extends('layouts.app')
@section('title', 'Edit Listing')
@section('content')

<div class="page-header">
  <div class="container">
    <h2><i class="bi bi-pencil me-2"></i>Edit Listing</h2>
    {{-- <p>Update the details for: {{ Str::limit($listing->title, 50) }}</p> --}}
  </div>
</div>

<div class="container py-4">
<div class="row justify-content-center">
    <div class="col-lg-8">

        @if($errors->any())
        <div class="mb-4" style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:12px;padding:1rem">
          <div class="d-flex gap-2">
            <i class="bi bi-exclamation-circle-fill" style="color:var(--red);margin-top:2px"></i>
            <div style="font-size:.88rem;color:var(--red)">
              @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
            </div>
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('seller.update', $listing->id) }}"
            enctype="multipart/form-data">
        @csrf 
        @method('PUT')

      </form>

    </div>
</div>
</div>

@endsection