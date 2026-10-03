@if ($paginator->hasPages())
    <nav class="admin-pagination" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="admin-pagination__btn is-disabled" aria-disabled="true">Prev</span>
        @else
            <a class="admin-pagination__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">Prev</a>
        @endif

        <div class="admin-pagination__pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="admin-pagination__ellipsis">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-pagination__page is-current" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="admin-pagination__page" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="admin-pagination__btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <span class="admin-pagination__btn is-disabled" aria-disabled="true">Next</span>
        @endif
    </nav>
@endif
