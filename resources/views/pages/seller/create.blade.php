@extends('layouts.app')
@section('title', 'Create Listing')
@section('content')

 <div class="page-header">
    <div class="container">
      <h2>Create New Listing</h2>
    </div>
  </div>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
    {{-- error message block  --}}
    @if($errors->any())
        <div style="background:var(--red-bg);border:1px solid var(--red-bd);border-radius:12px;
                    padding:1rem;margin-bottom:1.2rem">
          <div class="d-flex gap-2">
            <i class="bi bi-exclamation-circle-fill" style="color:var(--red);margin-top:2px"></i>
            <div style="font-size:.88rem;color:var(--red)">
              <div style="font-weight:700;margin-bottom:4px">Please fix the following errors:</div>
              @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
        <form method="POST" action="{{ route('seller.store') }}"
              enctype="multipart/form-data" id="createForm">
          @csrf
          {{-- Basic Info --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-card-text me-2"></i>Basic Information
          </div>

        <div class="mb-3">
            <label class="form-label-ax" for="title">Item Title</label>
            <input type="text" id="title" name="title"
                   class="form-control-ax"
                   value="{{ old('title') }}"
                   placeholder="enter title for item"
                   required />
            @error('title')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label-ax" for="description">Description </label>
            <textarea id="description" name="description" rows="5"
                      class="form-control-ax"
                      placeholder="enter brief discription about item"
                      required>{{ old('description') }}</textarea>
            @error('description')
              <div class="field-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label-ax" for="category">Category</label>
              <select id="category" name="category" class="form-select-ax" required>
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category</option>
                @foreach([
                    'art'=>'Art',
                    'watches'=>'Watches',
                    'vehicles'=>'Vehicles',
                    'jewelry'=>'Jewelry',
                    'collectibles'=>'Collectibles',
                    'electronics'=>'Electronics',
                    'other'=>'Other'
                    ] as $val => $label)
                  <option value="{{ $val }}" {{ old('category')===$val ? 'selected':'' }}>{{ $label }}</option>
                @endforeach
              </select>
              @error('category') 
              <div class="field-error">{{ $message }}</div>
               @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax" for="condition">Condition</label>
              <select id="condition" name="condition" class="form-select-ax" required>
                <option value="" disabled {{ old('condition') ? '' : 'selected' }}>Select condition</option>
                <option value="new"       {{ old('condition')==='new'       ? 'selected':'' }}>Brand New</option>
                <option value="like_new"  {{ old('condition')==='like_new'  ? 'selected':'' }}>Like New</option>
                <option value="excellent" {{ old('condition')==='excellent'  ? 'selected':'' }}>Excellent</option>
                <option value="good"      {{ old('condition')==='good'      ? 'selected':'' }}>Good</option>
                <option value="fair"      {{ old('condition')==='fair'      ? 'selected':'' }}>Fair</option>
              </select>
              @error('condition') 
              <div class="field-error">{{ $message }}</div> 
                @enderror
            </div>            
          </div>       
        </div>

        {{-- Image  --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-images me-2"></i>Item Image
          </div>
          <label for="image" id="dropZone"
            style="display:block;border:2px dashed var(--border);border-radius:12px;
                   padding:2.5rem;text-align:center;cursor:pointer;
                   background:var(--surface);transition:border-color .15s"
            onmouseover="this.style.borderColor='var(--br)'"
            onmouseout="this.style.borderColor='var(--border)'">
            <i class="bi bi-cloud-upload" style="font-size:2.5rem;color:var(--muted)"></i>
            <div style="font-weight:700;color:var(--text);margin-top:.5rem">Click to upload image</div>
            <div id="fileName" style="font-size:.82rem;color:var(--br);margin-top:8px;font-weight:600"></div>
          </label>
          <input type="file" id="image" name="image" accept="image/*" class="d-none"
                 onchange="document.getElementById('fileName').textContent = this.files[0]?.name || ''" />
          @error('image') <div class="field-error mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- Auction Schedule & Stating bid  --}}
        <div class="form-section">
          <div class="form-section-title">
            <i class="bi bi-clock me-2"></i>Auction Schedule & Starting Bid
          </div>
 
          <div style="background:var(--br-pale);border:1px solid var(--br-soft);
                      border-radius:10px;padding:1rem;margin-bottom:1rem">
            <div style="font-size:.8rem;color:var(--br);font-weight:700;margin-bottom:.6rem">Time Rules</div>
            <div style="font-size:.78rem;color:var(--muted);line-height:1.7">
              • Start time must be <strong>at least 30 minutes</strong> from now<br>
              • End time must be <strong>at least 1 hour after</strong> start time<br>
              • Auction cannot run for <strong>more than 30 days</strong><br>
              • Start and end time <strong>cannot be the same</strong>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label-ax" for="starts_at">Start Date & Time</label>
              <input type="datetime-local" id="starts_at" name="starts_at"
                     class="form-control-ax"
                     value="{{ old('starts_at') }}"
                     required />
              @error('starts_at') 
              <div class="field-error">{{ $message }}</div> 
              @enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label-ax" for="ends_at">End Date & Time</label>
              <input type="datetime-local" id="ends_at" name="ends_at"
                     class="form-control-ax"
                     value="{{ old('ends_at') }}"
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
                       value="{{ old('starting_bid') }}" placeholder="0"
                       min="1" step="1" required />
              </div>
              <div style="font-size:.75rem;color:var(--muted);margin-top:4px">
                This is the minimum bid buyers must start from.</div>
              @error('starting_bid') 
              <div class="field-error">{{ $message }}</div> 
              @enderror
            </div>
        </div>

        {{-- Submit Button  --}}
        <div class="d-flex gap-3 flex-wrap align-items-center justify-content-center">
          <button type="submit" class="btn btn-brown btn-lg px-5">
            Submit</button>
          <a href="{{ route('seller.dashboard') }}" class="btn btn-ghost-ax btn-lg px-5">
            Cancel</a>
          <div style="font-size:.78rem;color:var(--muted)">
            <i class="bi bi-shield-check me-1" style="color:var(--green)"></i>
            Listing will go to admin for review before going live.
          </div>
        </div>

        </form>
      </div>
    </div>
  </div>
@endsection

@push('styles')
<style>
.form-section{
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1.2rem;
}
.form-section-title{
  font-weight: 700;
  font-size: 1rem;
  color: var(--br);
  margin-bottom: 1.1rem;
  padding-bottom: .7rem;
  border-bottom: 1px solid var(--border);
}
.field-error{
  font-size: .78rem;
  color: var(--red);
  margin-top: 4px;
}
/* .type-card{
  display: block;
  border: 1.5px solid var(--border);
  border-radius: 12px;
  padding: 1rem;
  cursor: pointer;
  transition: all .15s;
} */
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const startsInput=document.getElementById('starts_at');
  const endsInput=document.getElementById('ends_at');
  const form=document.getElementById('createForm');

  // format Date to datetime-local string 
  function toLocalISO(date){
    const pad=n=>String(n).padStart(2,'0');
    return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate()) + 
    'T' + pad(date.getHours()) + ':' + pad(date.getMinutes());
  }

  // Set minimum start = now + 30 minutes
  function setStartMin(){
    const minStart=new Date(Date.now() + 30 * 60 * 1000);
    startsInput.min=toLocalISO(minStart);

    // If field is empty OR value is before minimum → auto-fill
    if(!startsInput.value || new Date(startsInput.value) < minStart){
      startsInput.value=toLocalISO(minStart);
    }
  }

  // Update end min whenever start changes
  function updateEndMin(){
    const startVal=startsInput.value;
    if(!startVal) 
    return;
 
    const start =new Date(startVal);
    // +1 hour
    const minEnd=new Date(start.getTime() + 60 * 60 * 1000); 
    endsInput.min = toLocalISO(minEnd);
    // If end is empty or before new minimum → auto-fill
    if(!endsInput.value || new Date(endsInput.value) < minEnd){
      endsInput.value=toLocalISO(minEnd);
    }
  }

  // Run on page load
   setStartMin();
   updateEndMin();

  //  Re-run every 60 sec so min stays fresh
  setInterval(setStartMin, 60000);

  // Listen for start change
  startsInput.addEventListener('change',updateEndMin);
  startsInput.addEventListener('input', updateEndMin);

  // Client-side validation on submit
  form.addEventListener('submit',function(e){
    const now=new Date();
    const minStart=new Date(now.getTime() + 30 * 60 * 1000);
    const startVal=new Date(startsInput.value);
    const endVal=new Date(endsInput.value);
    const minEnd=new Date(startVal.getTime() + 60 * 60 * 1000);
    const maxEnd=new Date(startVal.getTime() + 30 * 24 * 60 * 60 * 1000);

    // Clear old error messages
    document.querySelectorAll('.js-error').forEach(el=>el.remove());

    let valid = true;

    function showError(input, msg){
      const div=document.createElement('div');
      div.className='field-error js-error';
      div.textContent=msg;
      input.parentNode.appendChild(div);
      input.style.borderColor='var(--red)';
      valid=false;
    }

    // Rule 1: start must be >= now + 30 min
    if(!startsInput.value || startVal < minStart){
      showError(startsInput,'Start time must be at least 30 minutes from now.');
    }else{
      startsInput.style.borderColor = '';
    }
 
    // Rule 2: end must be >= start + 1 hour
    if(!endsInput.value || endVal < minEnd){
      showError(endsInput,'End time must be at least 1 hour after start time.');
    }
    // Rule 3: end cannot be same as start
    else if(startsInput.value === endsInput.value){
      showError(endsInput,'Start and end time cannot be the same.');
    }
    // Rule 4: max 30 days
    else if(endVal > maxEnd){
      showError(endsInput,'Auction cannot run for more than 30 days.');
    }else{
      endsInput.style.borderColor = '';
    }
 
    if(!valid){
      e.preventDefault();
      // Scroll to first error
      document.querySelector('.js-error')?.scrollIntoView({
        behavior: 'smooth',
        block: 'center'});
    }
  });

});
</script>
@endpush