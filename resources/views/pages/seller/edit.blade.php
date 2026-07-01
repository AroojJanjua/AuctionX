@extends('layouts.app')
@section('title', 'Edit Listing')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Edit Listing</h2>
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

      
       @if($listing->status === 'closed' || $listing->ends_at->isPast())
        <div style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:14px;padding:1.5rem;text-align:center">
          <i class="bi bi-lock-fill" style="font-size:2rem;color:var(--red);display:block;margin-bottom:.5rem"></i>
          <div style="font-weight:800;color:var(--red);margin-bottom:5px">This auction has ended and cannot be edited.</div>
        </div>
 
      @elseif($listing->bids_count > 0)
        <div style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:14px;padding:1.5rem;text-align:center">
          <i class="bi bi-shield-lock-fill" style="font-size:2rem;color:var(--red);display:block;margin-bottom:.5rem"></i>
          <div style="font-weight:800;color:var(--red)">This auction already has bids and cannot be edited.</div>
        </div>
 
      @else

      <form method="POST" action="{{ route('seller.update', $listing->id) }}"
            enctype="multipart/form-data">
        @csrf 
        @method('PUT')
        {{-- Basic Info --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-card-text me-2"></i>Basic Information
          </div>
 
          <div class="mb-3">
            <label class="form-label-ax" for="title">Item Title</label>
            <input type="text" id="title" name="title"
                   class="form-control-ax"
                   value="{{ old('title', $listing->title) }}"
                   placeholder="enter title for item"
                   required />
            @error('title')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>
 
          <div class="mb-3">
            <label class="form-label-ax" for="description">Description</label>
            <textarea id="description" name="description" rows="5"
                      class="form-control-ax"
                      placeholder="enter brief description about item"
                      required>{{ old('description', $listing->description) }}</textarea>
            @error('description')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>
 
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label-ax" for="category">Category</label>
              <select id="category" name="category" class="form-select-ax" required>
                <option value="" disabled>Select category</option>
                @foreach([
                    'art'          => 'Art',
                    'watches'      => 'Watches',
                    'vehicles'     => 'Vehicles',
                    'jewelry'      => 'Jewelry',
                    'collectibles' => 'Collectibles',
                    'electronics'  => 'Electronics',
                    'other'        => 'Other'
                  ] as $val => $label)
                  <option value="{{ $val }}" {{ old('category', $listing->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
              @error('category')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax" for="condition">Condition</label>
              <select id="condition" name="condition" class="form-select-ax" required>
                <option value="" disabled>Select condition</option>
                <option value="new"       {{ old('condition', $listing->condition) === 'new'       ? 'selected' : '' }}>Brand New</option>
                <option value="like_new"  {{ old('condition', $listing->condition) === 'like_new'  ? 'selected' : '' }}>Like New</option>
                <option value="excellent" {{ old('condition', $listing->condition) === 'excellent' ? 'selected' : '' }}>Excellent</option>
                <option value="good"      {{ old('condition', $listing->condition) === 'good'      ? 'selected' : '' }}>Good</option>
                <option value="fair"      {{ old('condition', $listing->condition) === 'fair'      ? 'selected' : '' }}>Fair</option>
              </select>
              @error('condition')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
 
        {{-- Image --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-images me-2"></i>Item Image
          </div>
          @if($listing->image)
            <div class="mb-3">
              <img src="{{ asset('storage/'.$listing->image) }}" alt="Current image"
                   style="height:120px;object-fit:cover;border-radius:10px;border:1px solid var(--border)">
              <div style="font-size:.78rem;color:var(--muted);margin-top:4px">Current image — upload a new one to replace it</div>
            </div>
          @endif
          <label for="image" id="dropZone"
            style="display:block;border:2px dashed var(--border);border-radius:12px;
                   padding:2.5rem;text-align:center;cursor:pointer;
                   background:var(--surface);transition:border-color .15s"
            onmouseover="this.style.borderColor='var(--br)'"
            onmouseout="this.style.borderColor='var(--border)'">
            <i class="bi bi-cloud-upload" style="font-size:2.5rem;color:var(--muted)"></i>
            <div style="font-weight:700;color:var(--text);margin-top:.5rem">Click to upload new image</div>
            <div id="fileName" style="font-size:.82rem;color:var(--br);margin-top:8px;font-weight:600"></div>
          </label>
          <input type="file" id="image" name="image" accept="image/*" class="d-none"
                 onchange="document.getElementById('fileName').textContent = this.files[0]?.name || ''" />
          @error('image') <div class="field-error mt-1">{{ $message }}</div> @enderror
        </div>
 
        {{-- Schedule & Pricing --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-clock me-2"></i>Schedule & Pricing
          </div>
 
          <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                      border-radius:10px;padding:1rem;margin-bottom:1rem">
            <div style="font-size:.8rem;color:var(--br);font-weight:700;margin-bottom:.6rem">Edit Rules</div>
            <div style="font-size:.78rem;color:var(--muted);line-height:1.7">
              • Start time is <strong>locked</strong> and cannot be changed<br>
              • End time must be <strong>at least 1 hour after</strong> start time<br>
              • Auction cannot run for <strong>more than 30 days</strong><br>
              • Price change will <strong>reset current bid</strong> to match
            </div>
          </div>
 
          <div class="row g-3 mb-3">
            <div class="col-sm-6">
              <label class="form-label-ax">Start Date & Time</label>
              <input type="text" class="form-control-ax"
                     value="{{ $listing->starts_at->format('d M Y, h:i A') }}" disabled />
              <div style="font-size:.75rem;color:var(--muted);margin-top:4px">
                <i class="bi bi-lock me-1"></i>Locked after creation
              </div>
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax" for="ends_at">End Date & Time</label>
              <input type="datetime-local" id="ends_at" name="ends_at"
                     class="form-control-ax"
                     value="{{ old('ends_at', $listing->ends_at->format('Y-m-d\TH:i')) }}"
                     required />
              @error('ends_at')
                <div class="field-error">{{ $message }}</div>
              @enderror
            </div>
          </div>
 
          <div class="col-sm-12">
            <label class="form-label-ax" for="starting_bid">Starting Bid</label>
            <div style="position:relative">
              <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                           color:var(--muted);font-size:.82rem;font-weight:600">pkr</span>
              <input type="number" id="starting_bid" name="starting_bid"
                     class="form-control-ax" style="padding-left:48px"
                     value="{{ old('starting_bid', (int)$listing->starting_bid) }}"
                     placeholder="0" min="1" step="1" required />
            </div>
            <div style="font-size:.75rem;color:var(--muted);margin-top:4px">
              Changing the price will reset the current bid to match.</div>
            @error('starting_bid')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
 
        {{-- Submit --}}
        <div class="d-flex gap-3 flex-wrap align-items-center justify-content-center">
          <button type="submit" class="btn btn-brown btn-lg px-5">Save</button>
          <a href="{{ route('seller.dashboard') }}" class="btn btn-ghost-ax btn-lg px-5">
            Cancel
          </a>
        </div>

      </form>
      @endif
    </div>
</div>
</div>

@endsection