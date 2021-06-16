<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
    @while($breadcrumb = Breadcrumb::getNext())

        @if($breadcrumb->code)
            <li itemprop='itemListElement' itemscope
                itemtype='https://schema.org/ListItem'>
                <a itemprop='item' itemid='https://example.com/books/sciencefiction'
                   href='{{ $breadcrumb->code }}'>
                    <span itemprop='name'>{{ $breadcrumb->name }}</span></a>
                <meta itemprop='position' content='$position' />
            </li>
        @else
            <li itemprop='itemListElement' itemscope
                itemtype='https://schema.org/ListItem'>
                <span itemprop='name'> {{ $breadcrumb->name }} </span>
                <meta itemprop='position' content='$position' />
            </li>
        @endif

    @endwhile
</ol>
