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
    <script src="/js/admin/main.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/simpleLightbox.js"></script>
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
        <div id="main-row" class="row ">
            <div id="sidebar" class="col-2 navbar-light bg-light">
                <ul class="nav flex-column navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.index') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.product.index') }}">Редактирование товаров</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.category') }}">Редактирование категорий</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.routes') }}">Редактироваие страниц</a>
                    </li>
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
</body>

</html>
