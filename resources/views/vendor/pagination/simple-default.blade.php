@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class=" disabled">
                <a class="" href="#!" ><i class="material-icons tiny">chevron_left</i>@lang('pagination.previous')</a>
            </li>
        @else
            <li class="">
                <a class="" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="material-icons tiny">chevron_left</i>@lang('pagination.previous')</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="">
                <a class="" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next') <i class="material-icons tiny">chevron_right</i></a>
            </li>
        @else
            <li class=" disabled">
                <a class="disabled" href="#!"> @lang('pagination.next')<i class="material-icons tiny">chevron_right</i></a>
            </li>
        @endif
    </ul>
@endif
