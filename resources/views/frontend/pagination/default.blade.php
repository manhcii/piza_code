@if ($paginator->hasPages())
<nav class="pagination">
    <ul class="page-numbers">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a class="page-link prev page-numbers">
                    {{-- <span aria-hidden="true">«</span> --}}
                </a>
            </li>
        @else
            <li class="page-item ">
                <a class="page-link prev page-numbers" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    aria-label="@lang('pagination.previous')">
                    {{-- <span aria-hidden="true">«</span> --}}
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item "><a class="page-link page-numbers">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item"><span class="page-link current page-numbers">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item "><a class="page-link page-numbers" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item ">
                <a class="page-link next page-numbers" href="{{ $paginator->nextPageUrl() }}" rel="next"
                    aria-label="@lang('pagination.next')">
                    {{-- <span aria-hidden="true">»</span> --}}
                </a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a class="page-link next page-numbers">
                    {{-- <span aria-hidden="true">»</span> --}}
                </a>
            </li>
        @endif
    </ul>
</nav>
@endif
