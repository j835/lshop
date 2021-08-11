<div id="header-mobile" class="row">
    @if (request()->url() == '/')
        <div class="logo unselectable">
            <img src="/img/logo-sm.jpg" alt="logo" class="logo">
        </div>
    @else
    <a class="logo unselectable" href="/">
        <img src="/img/logo-sm.jpg" alt="logo" class="logo">
    </a>
    @endif

    <div class="search unselectable">
        <i class="fas fa-search"></i>
    </div>
    <a class="profile unselectable" href="{{ route('profile.index') }}">
        <i class="fas fa-user"></i>
    </a>
    <a class="cart unselectable" href="{{ route('cart') }}">
        <i class="fas fa-shopping-cart"></i>
        <span class="counter">0</span>
    </a>

    <div class="burger unselectable">
        <i class="fas fa-bars"></i>
    </div>

</div>

<form id="search-mobile" method="get" action="{{ route('search') }}" class="row">
    <input type="text" name="q" value="" placeholder="Поиск...">
    <button type="submit"><i class="fas fa-search"></i></button>
</form>
