@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $window = 2; // pages on either side of current
        $start = max(1, $current - $window);
        $end = min($last, $current + $window);
        $queryParams = request()->except('page');
    @endphp

    <nav role="navigation" aria-label="Pagination Navigation" class="d-flex flex-column align-items-center w-100">
        <style>
            /* pill-style pagination */
            .pagination .page-link {
                border-radius: 999rem;
                padding-left: 0.6rem;
                padding-right: 0.6rem;
            }

            /* hide page numbers on very small screens to keep layout compact */
            @media (max-width: 480px) {
                .pagination .page-number {
                    display: none;
                }

                .pagination .page-link.current-visible {
                    display: inline-block;
                }
            }
        </style>

        <ul class="pagination pagination-sm mb-0">
            {{-- First --}}
            @if ($current == 1)
                <li class="page-item disabled"><span class="page-link">« First</span></li>
            @else
                <li class="page-item"><a class="page-link"
                        href="{{ $paginator->url(1) }}{{ http_build_query($queryParams) ? (strpos($paginator->url(1), '?') === false ? '?' : '&') . http_build_query($queryParams) : '' }}"
                        rel="first">« First</a></li>
            @endif

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i
                            class="bi bi-chevron-left"></i></span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>
            @endif

            {{-- Pages --}}
            @if ($start > 1)
                <li class="page-item page-number"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                @if ($start > 2)
                    <li class="page-item disabled page-number"><span class="page-link">…</span></li>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <li class="page-item active" aria-current="page"><span
                            class="page-link current-visible">{{ $page }}</span></li>
                @else
                    <li class="page-item page-number"><a class="page-link"
                            href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            @if ($end < $last)
                @if ($end < $last - 1)
                    <li class="page-item disabled page-number"><span class="page-link">…</span></li>
                @endif
                <li class="page-item page-number"><a class="page-link"
                        href="{{ $paginator->url($last) }}">{{ $last }}</a></li>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="Next"><i class="bi bi-chevron-right"></i></a></li>
            @else
                <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i
                            class="bi bi-chevron-right"></i></span></li>
            @endif

            {{-- Last --}}
            @if ($current == $last)
                <li class="page-item disabled"><span class="page-link">Last »</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($last) }}">Last »</a></li>
            @endif
        </ul>

        <div class="d-flex align-items-center gap-3 mt-2">
            <div class="small text-muted">Page {{ $current }} of {{ $last }} — {{ $paginator->total() }}
                results</div>

            <!-- Jump to page form -->
            <form method="GET" class="d-inline-flex align-items-center" style="gap:.5rem;"
                action="{{ request()->url() }}">
                @foreach (request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <label for="goto_page" class="visually-hidden">Go to page</label>
                <input id="goto_page" name="page" type="number" min="1" max="{{ $last }}"
                    class="form-control form-control-sm" style="width:5.5rem;" placeholder="#" />
                <button type="submit" class="btn btn-sm btn-outline-primary">Go</button>
            </form>
        </div>
    </nav>
@endif
