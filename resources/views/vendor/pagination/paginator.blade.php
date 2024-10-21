@php
    $totalPages = $paginator->lastPage();
    $currentPage = $paginator->currentPage();
    $range = 2;
@endphp

@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <a class="wow fadeInUp active" aria-disabled="true"><</a>
            </li>
        @else
            <li class="active">
                <a href="{{ $paginator->previousPageUrl() }}" class="wow fadeInUp" rel="prev"><</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @php
            // Pages to display at the beginning
            $startPages = [1, 2];

            // Pages to display at the end
            $endPages = [$totalPages - 1, $totalPages];

            // Pages to display around the current page
            $startPage = max($currentPage - $range, 3);
            $endPage = min($currentPage + $range, $totalPages - 2);
        @endphp

        {{-- Display the first set of pages --}}
        @foreach ($startPages as $page)
            @if ($page <= $totalPages)
                @if ($page == $currentPage)
                    <li>
                        <a>{{ $page }}</a>
                    </li>
                @else
                    <li class="active">
                        <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endif
        @endforeach

        {{-- Display "..." if there's a gap between the start and the current page --}}
        @if ($currentPage > $range + 2)
            <li>
                <a class="wow fadeInUp" aria-disabled="true">...</a>
            </li>
        @endif

        {{-- Display pages around the current page --}}
        @for ($page = $startPage; $page <= $endPage; $page++)
            @if ($page == $currentPage)
                <li>
                    <a aria-current="page">{{ $page }}</a>
                </li>
            @else
                <li class="active">
                    <a href="{{ $paginator->url($page) }}" >{{ $page }}</a>
                </li>
            @endif
        @endfor

        {{-- Display "..." if there's a gap between the current page and the end --}}
        @if ($currentPage < $totalPages - $range - 1)
            <li>
                <a aria-disabled="true">...</a>
            </li>
        @endif

        {{-- Display the last set of pages --}}
        @foreach ($endPages as $page)
            @if ($page <= $totalPages)
                @if ($page == $currentPage)
                    <li>
                        <a aria-current="page">{{ $page }}</a>
                    </li>
                @else
                    <li class="active">
                        <a href="{{ $paginator->url($page) }}" >{{ $page }}</a>
                    </li>
                @endif
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="active">
                <a href="{{ $paginator->nextPageUrl() }}" >
                    >
                </a>
            </li>
        @else
            <li>
                <a aria-disabled="true">></a>
            </li>
        @endif
    </ul>
@endif
