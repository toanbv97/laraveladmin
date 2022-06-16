@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li hidden>
                <a class="pagination__link" href="#"> <i class="fa-solid fa-angle-left"></i> </a>
            </li>
        @else
            <li>
                <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}"> <i class="fa-solid fa-angle-left"></i> </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                 <li class="page-item disabled">{{ $element }}</li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a class="pagination__link pagination__link--active" href="">{{ $page }}</a>
                        </li>
                    @else
                         <li>
                             <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                         </li>
                     @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li>
                <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}"> <i class="fa-solid fa-angle-right"></i> </a>
            </li>
        @else
            <li hidden>
                <a class="pagination__link" href=""> <i class="fa-solid fa-angle-right"></i> </a>
            </li>
        @endif
    </ul>
@endif

