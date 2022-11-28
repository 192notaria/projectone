@if ($paginator->hasPages())
    <h5>Registros totales: {{ $paginator->total() }}</h5>
    <div class="paginating-container">
        <div class="pagination-custom_solid">
            @if ($paginator->onFirstPage())
                <a wire:click="previousPage" style="pointer-events: none" class="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            @else
                <a style="cursor: pointer" wire:click="previousPage" class="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            @endif

            <ul class="pagination">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><a wire:click="gotoPage({{$page}})"class="active">{{$page}}</a></li>
                            @else
                                <li><a style="cursor: pointer" wire:click="gotoPage({{$page}})">{{$page}}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>

            @if ($paginator->hasMorePages())
                <a style="cursor: pointer" wire:click="nextPage" class="next active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            @else
                <a style="pointer-events: none" wire:click="nextPage" class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            @endif

        </div>

    </div>
@endif
