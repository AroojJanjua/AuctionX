@extends('layouts.app')
@section('title','Payment Management')
@section('content')

<div class="page-header">
  <div class="container">
    <h2>Payment Management</h2>
  </div>
</div>

<div class="container py-4">

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    @foreach([
      ['Pending Review',  $stats['pending_review'],                         'var(--br)'],
      ['Held in Escrow',  'PKR '.number_format($stats['total_held']),       'var(--br)'],
      ['Total Released',  'PKR '.number_format($stats['total_released']),   'var(--green)'],
      ['Platform Fees',   'PKR '.number_format($stats['total_fees']),       'var(--green)'],
      ['Active Disputes', $stats['dispute_count'],                          'var(--red)'],
    ] as [$label, $val, $color])
    <div class="col-sm-6 col-lg">
      <div style="background:#fff;border:1px solid var(--border);border-radius:14px;padding:1.1rem">
        <div style="font-size:.78rem;color:var(--muted);margin-bottom:3px">{{ $label }}</div>
        <div style="font-size:1.3rem;font-weight:800;color:{{ $color }}">{{ $val }}</div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Table --}}
  <div style="background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden">
    <div class="px-4 py-3" style="border-bottom:1px solid var(--border);font-weight:700">All Payments</div>

    @if($payments->isEmpty())
      <div class="text-center py-5" style="color:var(--muted)">
        <i class="bi bi-cash-coin" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
        No payments yet
      </div>
    @else
    <div class="table-responsive">
      <table class="table mb-0" style="font-size:.85rem">
        <thead>
          <tr style="border-bottom:1px solid var(--border);background:var(--surface-1)">
            <th style="padding:10px 16px;font-weight:600">Auction</th>
            <th style="padding:10px 16px;font-weight:600">Buyer</th>
            <th style="padding:10px 16px;font-weight:600">Method</th>
            <th style="padding:10px 16px;font-weight:600">Amount</th>
            <th style="padding:10px 16px;font-weight:600">Status</th>
            <th style="padding:10px 16px;font-weight:600">Date</th>
            <th style="padding:10px 16px;font-weight:600">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $payment)
          @php
            $badges=[
              'pending'  => 'badge-drafted',
              'submitted'=> 'badge-drafted',
              'held'     => 'badge-drafted',
              'shipped'  => 'badge-timed',
              'received' => 'badge-timed',
              'released' => 'badge-timed',
              'refunded' => 'badge-closed',
              'disputed' => 'badge-closed',
            ];
          @endphp
          <tr style="border-bottom:1px solid var(--border)">
            <td style="padding:12px 16px;vertical-align:middle">
              <a href="{{ route('auctions.show', $payment->auction_id) }}"
                 style="font-weight:700;color:var(--br);text-decoration:none">
                {{ Str::limit($payment->auction->title, 28) }}
              </a>
            </td>
            <td style="padding:12px 16px;vertical-align:middle">{{ $payment->buyer->name }}</td>
            <td style="padding:12px 16px;vertical-align:middle">
              @if($payment->payment_method)
                <span style="font-weight:600">{{ $payment->methodLabel() }}</span>
                @if($payment->transaction_id)
                  <div style="font-size:.72rem;color:var(--muted);font-family:var(--font-mono)">
                    {{ $payment->transaction_id }}
                  </div>
                @endif
              @else
                <span style="color:var(--muted)">—</span>
              @endif
            </td>
            <td style="padding:12px 16px;vertical-align:middle;font-weight:700;color:var(--br)">
              PKR {{ number_format($payment->amount) }}
              <div style="font-size:.72rem;color:var(--muted);font-weight:400">
                Seller: PKR {{ number_format($payment->seller_amount) }}
              </div>
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <span class="badge rounded-pill {{ $badges[$payment->status] ?? 'badge-drafted' }}">
                {{ ucfirst($payment->status) }}
              </span>
              @if($payment->shipped_at)
                <div style="font-size:.7rem;color:var(--muted);margin-top:2px">{{ $payment->courier_name }}</div>
              @endif
            </td>
            <td style="padding:12px 16px;vertical-align:middle;color:var(--muted);font-size:.78rem">
              {{ ($payment->submitted_at ?? $payment->created_at)?->format('M d, Y') }}
            </td>
            <td style="padding:12px 16px;vertical-align:middle">
              <div class="d-flex gap-1">

                {{-- View full status page --}}
                <a href="{{ route('payment.status', $payment->auction_id) }}"
                  class="btn btn-ghost-ax btn-sm" title="View payment status">
                  <i class="bi bi-clipboard-data"></i>
                </a>

                {{-- View proof --}}
                <button class="btn btn-ghost-ax btn-sm"
                  onclick="openModal('view-{{ $payment->id }}')" title="View proof">
                  <i class="bi bi-eye"></i>
                </button>

                {{-- Confirm --}}
                @if($payment->isSubmitted())
                <button class="btn btn-sm btn-green"
                  onclick="openModal('confirm-{{ $payment->id }}')" title="Confirm payment">
                  <i class="bi bi-check2"></i>
                </button>
                @endif

                {{-- View Dispute --}}
                @if($payment->isDisputed())
                <button class="btn btn-sm"
                  style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)"
                  onclick="openModal('dispute-{{ $payment->id }}')" title="View dispute details">
                  <i class="bi bi-flag-fill"></i>
                </button>
                @endif
 
                {{-- Release --}}
                @if(in_array($payment->status, ['held','shipped','received','disputed']))
                <button class="btn btn-sm"
                  style="background:#E1F5EE;color:var(--green);border:1px solid #A8DFC9"
                  onclick="openModal('release-{{ $payment->id }}')" title="Release to seller">
                  <i class="bi bi-send-fill"></i>
                </button>
                @endif

                {{-- Refund --}}
                @if(in_array($payment->status, ['submitted','held','shipped','received','disputed']))
                <button class="btn btn-sm"
                  style="background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)"
                  onclick="openModal('refund-{{ $payment->id }}')" title="Refund to buyer">
                  <i class="bi bi-arrow-counterclockwise"></i>
                </button>
                @endif

              </div>
            </td>
          </tr>

          {{-- View Proof Modal --}}
          <div id="view-{{ $payment->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;max-width:500px;width:90%;max-height:90vh;overflow-y:auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-weight:700">Proof from {{ $payment->buyer->name }}</div>
                <button type="button" onclick="closeModal('view-{{ $payment->id }}')"
                  style="background:none;border:none;font-size:1.3rem;cursor:pointer;color:var(--muted)">&times;</button>
              </div>
              @if($payment->proof_image)
                <img src="{{ Storage::url($payment->proof_image) }}" alt="Payment proof"
                     style="width:100%;border-radius:10px;border:1px solid var(--border);margin-bottom:1rem">
              @else
                <div style="text-align:center;color:var(--muted);padding:2rem">No screenshot uploaded</div>
              @endif
              @if($payment->transaction_id)
                <div style="font-size:.83rem;margin-bottom:.5rem">
                  <strong>Transaction ID:</strong> <span style="font-family:var(--font-mono)">{{ $payment->transaction_id }}</span>
                </div>
              @endif
              @if($payment->buyer_note)
              <div style="font-size:.83rem;margin-bottom:.5rem">
                  <strong>Buyer note:</strong> <span style="font-family:var(--font-mono)">{{ $payment->buyer_note }}</span>
                </div>
              @endif
            </div>
          </div>

          {{-- Confirm Modal --}}
          @if($payment->isSubmitted())
          <div id="confirm-{{ $payment->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;max-width:400px;width:90%">
              <div style="font-weight:700;margin-bottom:.5rem">Confirm Payment</div>
              <div style="font-size:.85rem;color:var(--muted);margin-bottom:1rem">
                Confirm PKR {{ number_format($payment->amount) }} received via {{ $payment->methodLabel() }} from {{ $payment->buyer->name }}?
                This moves the payment to escrow and tells the seller to ship.
              </div>
              <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}">
                @csrf
                <textarea name="note" class="form-control-ax mb-3" rows="2"
                  placeholder="Optional note…" style="resize:none"></textarea>
                <div class="d-flex justify-content-center gap-2">
                  <button class="btn btn-green w-50">Confirm</button>
                  <button type="button" class="btn btn-ghost-ax w-50" onclick="closeModal('confirm-{{ $payment->id }}')">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          @endif

          {{-- Dispute Details Modal --}}
          @if($payment->isDisputed())
          <div id="dispute-{{ $payment->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;max-width:520px;width:90%;max-height:90vh;overflow-y:auto">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-weight:700;color:var(--red)">Dispute Details</div>
                <button type="button" onclick="closeModal('dispute-{{ $payment->id }}')"
                  style="background:none;border:none;font-size:1.3rem;cursor:pointer;color:var(--muted)">&times;</button>
              </div>
 
              <div style="font-weight:800;font-size:.82rem;margin-bottom:.3rem">Buyer's Statement</div>
              @if($payment->buyer_statement)
                <div style="font-size:.9rem;background:var(--surface,#F5F0EB);padding:.75rem;border-radius:8px;margin-bottom:.3rem">
                  {{ $payment->buyer_statement }}
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.75rem">{{ $payment->buyer_statement_at?->format('M d, Y g:ia') }}</div>
                @if($payment->buyer_statement_evidence)
                  <img src="{{ Storage::url($payment->buyer_statement_evidence) }}" alt="Buyer evidence"
                       style="width:100%;border-radius:10px;border:1px solid var(--border);margin-bottom:1rem">
                @endif
              @else
                <div style="font-size:.83rem;color:var(--muted);font-style:italic;margin-bottom:1rem">Not submitted yet.</div>
              @endif
 
              <hr style="border-color:var(--border)">
 
              <div style="font-weight:800;font-size:.82rem;margin-bottom:.3rem">Seller's Statement</div>
              @if($payment->seller_statement)
                <div style="font-size:.9rem;background:var(--surface,#F5F0EB);padding:.75rem;border-radius:8px;margin-bottom:.3rem">
                  {{ $payment->seller_statement }}
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.75rem">{{ $payment->seller_statement_at?->format('M d, Y g:ia') }}</div>
                @if($payment->seller_statement_evidence)
                  <img src="{{ Storage::url($payment->seller_statement_evidence) }}" alt="Seller evidence"
                       style="width:100%;border-radius:10px;border:1px solid var(--border)">
                @endif
              @else
                <div style="font-size:.83rem;color:var(--muted);font-style:italic">Not submitted yet.</div>
              @endif
 
            </div>
          </div>
          @endif
 
          {{-- Release Modal --}}
          @if(in_array($payment->status, ['held','shipped','received','disputed']))
          <div id="release-{{ $payment->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;max-width:400px;width:90%">
              <div style="font-weight:700;margin-bottom:.5rem">Release to Seller</div>
              <div style="font-size:.85rem;color:var(--muted);margin-bottom:1rem">
                Release PKR {{ number_format($payment->seller_amount) }} to {{ $payment->seller->name }}?
              </div>
              @if($payment->isDisputed())
                <div style="font-size:.78rem;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);padding:.6rem .75rem;border-radius:8px;margin-bottom:1rem">
                  <i class="bi bi-exclamation-triangle-fill me-1"></i>
                  This payment is disputed{{ ($payment->buyer_statement && $payment->seller_statement) ? '' : ' — not both statements have been submitted yet' }}.
                  <a href="#" onclick="closeModal('release-{{ $payment->id }}');openModal('dispute-{{ $payment->id }}');return false;" style="color:var(--red);text-decoration:underline">Review the dispute</a> before releasing.
                </div>
              @endif
              @if($payment->seller->hasPayoutDetails())
                <div style="background:var(--surface,#F5F0EB);border:1px solid var(--border);border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem">
                  <div style="font-size:.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:.03em;margin-bottom:.3rem">Send payment to</div>
                  <div style="font-weight:700;font-size:.9rem">{{ ucfirst($payment->seller->payout_method) }} <br> {{ $payment->seller->payout_account_number }}</div>
                  <div style="font-size:.8rem;color:var(--muted)">{{ $payment->seller->payout_account_name }}</div>
                </div>
              @else
                <div style="font-size:.8rem;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);padding:.6rem .75rem;border-radius:8px;margin-bottom:1rem">
                  <i class="bi bi-exclamation-triangle-fill me-1"></i>This seller hasn't added payout details yet.</div>
              @endif
              <form method="POST" action="{{ route('admin.payments.release', $payment->id) }}">
                @csrf
                <textarea name="note" class="form-control-ax mb-3" rows="2"
                  placeholder="any note (optional)" style="resize:none"></textarea>
                <div class="d-flex justify-content-center gap-2">
                  <button class="btn btn-green w-50">Release Payment</button>
                  <button type="button" class="btn btn-ghost-ax w-50" onclick="closeModal('release-{{ $payment->id }}')">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          @endif

          {{-- Refund Modal --}}
          @if(in_array($payment->status, ['submitted','held','shipped','received','disputed']))
          <div id="refund-{{ $payment->id }}" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center">
            <div style="background:#fff;border-radius:16px;padding:1.5rem;max-width:400px;width:90%">
              <div style="font-weight:700;margin-bottom:.5rem;color:var(--red)">Issue Refund</div>
              <div style="font-size:.85rem;color:var(--muted);margin-bottom:1rem">
                Refund PKR {{ number_format($payment->amount) }} to {{ $payment->buyer->name }}?
              </div>
              @if($payment->isDisputed())
                <div style="font-size:.78rem;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);padding:.6rem .75rem;border-radius:8px;margin-bottom:1rem">
                  <i class="bi bi-exclamation-triangle-fill me-1"></i>
                  This payment is disputed{{ ($payment->buyer_statement && $payment->seller_statement) ? '' : ' — not both statements have been submitted yet' }}.
                  <a href="#" onclick="closeModal('refund-{{ $payment->id }}');openModal('dispute-{{ $payment->id }}');return false;" style="color:var(--red);text-decoration:underline">Review the dispute</a> before refunding.
                </div>
              @endif
              <form method="POST" action="{{ route('admin.payments.refund', $payment->id) }}">
                @csrf
                <textarea name="note" class="form-control-ax mb-3" rows="2"
                  placeholder="Reason for refund…" required style="resize:none"></textarea>
                <div class="d-flex gap-2">
                  <button class="btn btn-red w-50">Confirm Refund</button>
                  <button type="button" class="btn btn-ghost-ax w-50" onclick="closeModal('refund-{{ $payment->id }}')">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          @endif

          @endforeach
        </tbody>
      </table>
    </div>

    @if($payments->hasPages())
    <div class="p-3 d-flex justify-content-center">
      {{ $payments->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
    @endif
  </div>
</div>

@push('scripts')
<script>
function openModal(id){ 
  document.getElementById(id).style.display='flex'; 
}
function closeModal(id){ 
  document.getElementById(id).style.display='none'; 
}
document.querySelectorAll('[id^="view-"],[id^="confirm-"],[id^="release-"],[id^="refund-"]').forEach(function(el){  //start with operator
  el.addEventListener('click',function(e){ //current element
    if(e.target===this) 
      closeModal(this.id); 
    });
});
</script>
@endpush
@endsection