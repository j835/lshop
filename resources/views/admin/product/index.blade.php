@extends('admin.layouts.main')

@section('content')
    <h3>Поиск товара по названию:</h3>
    <form action="" method="get" id="search-form" class="form">
        <input class="form-control" type="text" class="" name="q">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>

    <h3 style="margin-top:20px;">Поиск товара по категории:</h3>
    <div id="product-index">
        @include('catalog.menu')
    </div>

    <script>
        let link_base = '{{ route('admin.product.select') . '/' }}';
        let links = document.querySelectorAll('.category>a');
        for (let link of links) {
        link.href = link_base + '?category_id=' + link.dataset.id;
        let submenu = $(link).siblings('.submenu')[0];
        if (submenu) {
            link.href = '#'
            link.classList.add('arrow');
            $(link).click(function (e) {
                e.preventDefault();
                if (link.classList.contains('collapsed')) {
                    $(submenu).slideUp();
                    link.classList.remove('collapsed');
                } else {
                    $(submenu).slideDown();
                    link.classList.add('collapsed');
                }
            })
            } else {
                link.href = link_base + '?category_id=' + link.dataset.id;
            }
        }
    </script>
@endsection
