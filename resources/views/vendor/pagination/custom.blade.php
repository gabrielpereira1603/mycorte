<!-- resources/views/vendor/pagination/custom.blade.php -->
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Link para a página anterior --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Links de Paginação --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Link para a próxima página --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span>&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif

<style>
    /* Estilos de paginação personalizada */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        display: block;
        padding: 8px 12px;
        color: #3A4976;
        text-decoration: none;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination li a:hover {
        background-color: #3A4976;
        color: #fff;
    }

    .pagination li.active span {
        background-color: #3A4976;
        color: #fff;
        border-color: #3A4976;
    }

    .pagination li.disabled span {
        color: #ddd;
    }
</style>
