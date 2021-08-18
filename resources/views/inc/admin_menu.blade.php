<ul class="nav flex-column navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.index') }}" style="font-size:18px;">Главная</a>
    </li>
    @can('product.get')
    <div class="nav-header  unselectable">Товары<i class="fas fa-arrow-right"></i></div>
    <div class="nav-group">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.product.create') }}">Создание товара</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.product.select') }}">Редактирование товаров</a>
        </li>
    </div>
    @endcan

    @can('store.get')
        <div class="nav-header unselectable">Склады<i class="fas fa-arrow-right"></i></div>
        <div class="nav-group">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.store.create') }}">Создание склада</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.store.select') }}">Управление складами</a>
            </li>
        </div> 
    @endcan

    @can('category.get')
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
    @endcan
    
    @can('page.get')
    <div class="nav-header unselectable">Страницы<i class="fas fa-arrow-right"></i></div>
    <div class="nav-group">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.page.create') }}">Создание страниц</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.page.select') }}">Управление страницами</a>
        </li>
    </div>
    @endcan

    @can('menu')
    <div class="nav-header unselectable">Меню<i class="fas fa-arrow-right"></i></div>
    <div class="nav-group">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.menu.create') }}">Создание меню</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.menu.select') }}">Управление меню</a>
        </li>
    </div>
    @endcan


    <div class="nav-header unselectable">Пользователи<i class="fas fa-arrow-right"></i></div>
    <div class="nav-group">
        @can('user.get')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.create') }}">Создать пользователя</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user.select') }}">Управление пользователями</a>
        </li>
        @endcan
        @can('user.role.get')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.role.select') }}">Группы пользователей</a>
        </li>
        @endcan

    </div>
    @can('order.get')
    <div class="nav-header unselectable">Заказы</div>
    <div class="nav-group">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order.select') }}">Заказы</a>
        </li>
    </div>
    @endcan

</ul>