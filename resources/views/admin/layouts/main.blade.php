<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Seo::getTitle() }}</title>
    <link rel="stylesheet" href="/css/admin/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <link rel="stylesheet" href="/css/simpleLightbox.css">
    <link rel="stylesheet" href="/css/admin/jquery.modal.min.css">
    <script src="/js/admin/main.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/simpleLightbox.js"></script>
    <script src="/js/admin/jquery.modal.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary" id="header" style="">
            <div class="container">
                <a href="/" class="navbar-brand">{{ config('app.name') }}</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" class="logout btn btn-primary btn-lg">Выход</button>
                </form>
            </div>
        </div>
        <div id="main-row" class="row">
            <div id="sidebar" class="col-2 navbar-light bg-light">
                <ul class="nav flex-column navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.index') }}" style="font-size:18px;">Главная</a>
                    </li>
                    <div class="nav-header">Товары</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.product.create') }}">Создание товара</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.product.index') }}">Редактирование товаров</a>
                        </li>
                    </div>

                    <div class="nav-header">Категории</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Создание категории</a>
                        </li><li class="nav-item">
                            <a class="nav-link" href="#">Редактирование категорий</a>
                        </li>
                    </div>

                    <div class="nav-header">Страницы</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Создание страниц</a>
                        </li><li class="nav-item">
                            <a class="nav-link" href="#">Изменение страниц</a>
                        </li>
                    </div>

                    <div class="nav-header">Пользователи</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Управление пользователями</a>
                        </li><li class="nav-item">
                            <a class="nav-link" href="#">Группы пользователей</a>
                        </li>
                    </div>

                    <div class="nav-header">Заказы</div>
                    <div class="nav-group">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Список заказов</a>
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

    <div id="chooseCategory" class="modal">
        <a href="#" rel="modal:close" class="btn btn-light" style="width:150px;">Закрыть</a>
        <div style="border-bottom:1px solid rgba(0,0,0,0.1);margin-bottom:10px;height:10px;"></div>
        <div id="categories-dropdown-list">
            @include('catalog.menu')
        </div>
    </div>
</body>

</html>
