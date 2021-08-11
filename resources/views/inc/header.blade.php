<div id="header" class="row">
    <div class="wrapper col-lg-9 col-12">
        <div class="burger-wrapper col-2">
            <img class="burger mobile-icon" src="/img/icon/burger.png" alt="burger">
        </div>
        <div class="logo-wrapper col-md-3 col-6">
            <a href="/">
                <img src="/img/logo.jpg" alt="logo" class="logo">
            </a>
        </div>
        <form action="{{ route('search') }}" method="GET" class="col-md-4" id="search-form">
            <input type="text" name="q" class="search-input" placeholder="Поиск..." value="{{ request()->q}}">
            <div id="search-results">
                <div class=" search-head">
                    <div class="title">
                        Результаты поиска
                    </div>
                    <div class="close">
                        X
                    </div>
                </div>
                <div class="search-body">

                </div>

                <div class="search-footer">
                    <a href="">Все результаты</a>
                </div>
            </div>
        </form>
        @auth
            <a class="login col-md-2" href="{{ route('profile.index') }}">
                Личный кабинет
            </a>
            <form action="{{ route('logout') }}/" method="post" class="logout col-md-1">
                @csrf
                <input type="submit" value="Выход">
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}/" class="login col-md-1">
                Войти
            </a>
        @endguest

        <div id="cart-button" class=" col-md-2">
            <img src="/img/icon/basket.png" alt="cart">
            <div class="total-price">0</div>
            <div class="rouble">₽</div>
            <div id="cart">
                <div class="cart-head">
                    Ваша корзина <span>0 товаров</span>
                </div>
                <div class="cart-products">

                </div>
                <div class="cart-total">
                    Всего: <span>0 ₽</span>
                </div>
                <div class="div cart-buttons">
                    <a class="cart-button" href="/cart/">
                        Перейти в корзину
                    </a>
                    <a class="order-button" href="/order/">
                        Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
