@if ($paginator->hasPages())
<nav aria-label="Pagination">
  <div class="d-flex justify-content-center">
    <ul style="list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:6px;align-items:center">

      {{-- Previous --}}
      @if ($paginator->onFirstPage())
        <li>
          <span style="display:inline-flex;align-items:center;justify-content:center;
                       width:36px;height:36px;border-radius:8px;font-size:.85rem;
                       border:1.5px solid var(--border);color:var(--border);
                       background:var(--surface);cursor:not-allowed">
            <i class="bi bi-chevron-left"></i>
          </span>
        </li>
      @else
        <li>
          <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
             style="display:inline-flex;align-items:center;justify-content:center;
                    width:36px;height:36px;border-radius:8px;font-size:.85rem;
                    border:1.5px solid var(--border);color:var(--br);
                    background:#fff;text-decoration:none;transition:all .15s"
             onmouseover="this.style.background='var(--br-pale)';this.style.borderColor='var(--br)'"
             onmouseout="this.style.background='#fff';this.style.borderColor='var(--border)'">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>
      @endif

      {{-- Page numbers --}}
      @foreach ($elements as $element)
        @if (is_string($element))
          <li>
            <span style="display:inline-flex;align-items:center;justify-content:center;
                         width:36px;height:36px;border-radius:8px;font-size:.85rem;
                         color:var(--muted)">…</span>
          </li>
        @endif

        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li>
                <span style="display:inline-flex;align-items:center;justify-content:center;
                             width:36px;height:36px;border-radius:8px;font-size:.85rem;
                             font-weight:700;background:var(--br);color:#fff;
                             border:1.5px solid var(--br)">
                  {{ $page }}
                </span>
              </li>
            @else
              <li>
                <a href="{{ $url }}"
                   style="display:inline-flex;align-items:center;justify-content:center;
                          width:36px;height:36px;border-radius:8px;font-size:.85rem;
                          border:1.5px solid var(--border);color:var(--text);
                          background:#fff;text-decoration:none;transition:all .15s"
                   onmouseover="this.style.background='var(--br-pale)';this.style.borderColor='var(--br)';this.style.color='var(--br)'"
                   onmouseout="this.style.background='#fff';this.style.borderColor='var(--border)';this.style.color='var(--text)'">
                  {{ $page }}
                </a>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next --}}
      @if ($paginator->hasMorePages())
        <li>
          <a href="{{ $paginator->nextPageUrl() }}" rel="next"
             style="display:inline-flex;align-items:center;justify-content:center;
                    width:36px;height:36px;border-radius:8px;font-size:.85rem;
                    border:1.5px solid var(--border);color:var(--br);
                    background:#fff;text-decoration:none;transition:all .15s"
             onmouseover="this.style.background='var(--br-pale)';this.style.borderColor='var(--br)'"
             onmouseout="this.style.background='#fff';this.style.borderColor='var(--border)'">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      @else
        <li>
          <span style="display:inline-flex;align-items:center;justify-content:center;
                       width:36px;height:36px;border-radius:8px;font-size:.85rem;
                       border:1.5px solid var(--border);color:var(--border);
                       background:var(--surface);cursor:not-allowed">
            <i class="bi bi-chevron-right"></i>
          </span>
        </li>
      @endif

    </ul>
  </div>
</nav>
@endif