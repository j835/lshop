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
                @include('inc.admin_menu')
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
