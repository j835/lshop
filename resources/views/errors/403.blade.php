<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Доступ запрещен</title>
    <link rel="stylesheet" href="/css/admin/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin/admin.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
</head>

<body>
    <div class="container">
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary" id="header" style="">
            <div class="container">
                <span style="color:white;font-size:22px;">Ошибка 403 - доступ запрещен</span>     
            </div>
        </div>
        <div id="main-row" class="row">
            <div class="col-12">
                <div class="row">
                    <a href="{{ url()->previous() }}" class="btn btn-link disabled back-button col-1" 
                        style="margin-top:20px;margin-left:20px;color:#212529;font-weight:bold;">
                        ← Назад</a>
                    <div class="col-11"></div>
                </div>

                <h1 class="fatal-error alert">Доступ запрещен</h1>
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary" style="width:200px;margin-left:20px;">Вход</a>
            <div id="footer" class="col-12"></div>
        </div>
    </div>
</body>

</html>
