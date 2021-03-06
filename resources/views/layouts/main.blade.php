<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{Seo::getDescription()}}">
    <meta name="keywords" content="{{Seo::getKeywords()}}"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico">
    <title>{{Seo::getTitle()}}</title>
    <link rel="stylesheet" href="/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <link rel="stylesheet" href="/css/solid.min.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/slick-theme.min.css">
    <link rel="stylesheet" href="/css/simpleLightbox.css">

    <script src="/js/jquery.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/simpleLightbox.js"></script>
    <script src="/js/Cart.js"></script>
    <script src="/js/SearchBar.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<div class="container-fluid">
    @can('admin')
        <div id="admin-link" class="row">
            <a href="{{ route('admin.index')}}">Панель Администратора</a>    
        </div>        
    @endcan
    @include('inc.header_top')
    @include('inc.header')
    @include('inc.header_mobile')
    <div class="container main">
        <div class="main-row row">
            <div id="sidebar" class="col-md-3 col-12">
                <div class="catalog-name">Каталог</div>
                @include('catalog.menu')
            </div>

            <div class="content col-md-9 col-12">
                <div id="breadcrumb" class="col-12">@include('inc.breadcrumb')</div>
                @yield("content")
            </div>
        </div>
    </div>
    @include('inc.footer')
</div>

<script>
</script>
</body>
</html>
