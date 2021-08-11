<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico">
    <title>{{ Seo::getTitle() }}</title>
    <link rel="stylesheet" href="/css/admin/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <link rel="stylesheet" href="/css/simpleLightbox.css">
    <link rel="stylesheet" href="/css/admin/jquery.modal.min.css">
    <script src="/js/jquery.js"></script>
    <script src="/js/admin/main.js"></script>
    <script src="/js/simpleLightbox.js"></script>
    <script src="/js/admin/jquery.modal.min.js"></script>
    <script src="/js/admin/ckeditor/ckeditor.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary" id="header" style="">
            <div class="container">
                <a href="/" class="navbar-brand">{{ config('app.name') }}</a>
                <a class="btn btn-primary user-link"
                    href="{{ route('admin.user.update', ['id' => auth()->user()->id]) }}"><i class="fas fa-user"></i>
                    {{ Auth::user()->name }}</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout btn btn-primary btn-lg">Выход <i class="fas fa-sign-out-alt"
                            style="margin-left:8px"></i></button>
                </form>
            </div>
        </div>
        <div id="main-row" class="row">
            <div id="sidebar" class="col-2 navbar-light bg-light">
                <ul class="nav flex-column navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.index') }}" style="font-size:18px;">Главная</a>
                    </li>
                    <div class="nav-header  unselectable">Товары<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.product.create') }}">Создание товара</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.product.select') }}">Редактирование товаров</a>
                        </li>
                    </div>

                    <div class="nav-header unselectable">Склады<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.store.create') }}">Создание склада</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.store.select') }}">Управление складами</a>
                        </li>
                    </div>

                    <div class="nav-header unselectable">Категории<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.category.create') }}">Создание категории</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.category.select') }}">Редактирование
                                категорий</a>
                        </li>
                    </div>

                    <div class="nav-header unselectable">Страницы<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.create') }}">Создание страниц</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.select') }}">Управление страницами</a>
                        </li>
                    </div>

                    <div class="nav-header unselectable">Меню<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.menu.create') }}">Создание меню</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.menu.select') }}">Управление меню</a>
                        </li>
                    </div>

                    <div class="nav-header unselectable">Пользователи<i class="fas fa-arrow-right"></i></div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.create') }}">Создать пользователя</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.select') }}">Управление пользователями</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.role.select') }}">Группы пользователей</a>
                        </li>

                    </div>

                    <div class="nav-header unselectable">Заказы</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.order.select') }}">Заказы</a>
                        </li>
                    </div>


                </ul>
            </div>
            <div class="col-2" id="sidebar-padding"></div>
            <div class="col-10">
                <div id="content" class="row">
                    @yield('content')
                </div>
            </div>

            <div id="footer" class="col-12"></div>
        </div>
    </div>

    <div id="productCategorySelect" class="modal">
        <a href="#" rel="modal:close" class="btn btn-light" style="width:150px;">Закрыть</a>
        <div style="border-bottom:1px solid rgba(0,0,0,0.1);margin-bottom:10px;height:10px;"></div>
        <div class="categories-list">
            @include('catalog.menu')
        </div>
    </div>

    <div id="categoryCategorySelect" class="modal">
        <a href="#" rel="modal:close" class="btn btn-light" style="width:150px;">Закрыть</a>
        <div style="border-bottom:1px solid rgba(0,0,0,0.1);margin-bottom:10px;height:10px;"></div>
        <div class="categories-list">
            <div class="category">
                <a data-id="0" href="/catalog/aksessuary/">Верхний уровень</a>
                <div class="subcategory">
                    @include('catalog.menu')
                </div>
            </div>
        </div>
    </div>

  
</body>

</html>
