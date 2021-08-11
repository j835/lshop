<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Товар #

        $this->makePermission('Товары: просмотр', 'product.get');
        $this->makePermission('Товары: изменение', 'product.update');
        $this->makePermission('Товары: создание', 'product.create');
        $this->makePermission('Товары: удаление', 'product.delete');

        # Категория #

        $this->makePermission('Категории: просмотр', 'category.get');
        $this->makePermission('Категории: изменение', 'category.update');
        $this->makePermission('Категории: создание', 'category.create');
        $this->makePermission('Категории: удаление', 'category.delete');

        # Пользователь #

        $this->makePermission('Пользователи: просмотр', 'user.get');
        $this->makePermission('Пользователи: изменение', 'user.update');
        $this->makePermission('Пользователи: создание', 'user.create');
        $this->makePermission('Пользователи: создание', 'user.delete');

        # Группы пользователей #

        $this->makePermission('Группы пользователей: просмотр', 'user.role.get');
        $this->makePermission('Группы пользователей: изменение', 'user.role.update');
        $this->makePermission('Группы пользователей: создание', 'user.role.create');
        $this->makePermission('Группы пользователей: удаление', 'user.role.delete');

        # Статичные страницы #

        $this->makePermission('Статичные страницы: просмотр', 'page.get');
        $this->makePermission('Статичные страницы: изменение', 'page.update');
        $this->makePermission('Статичные страницы: создание', 'page.create');
        $this->makePermission('Статичные страницы: удаление', 'page.delete');

        # Заказы #

        $this->makePermission('Заказы: просмотр', 'order.get');
        $this->makePermission('Заказы: изменение', 'order.update');
        $this->makePermission('Заказы: удаление', 'order.delete');

        # Бэкап #

        $this->makePermission('Управление резервными копиями', 'backup');

        # email # 

        $this->makePermission('Управление почтой', 'email');

        # Доступ в админ-панель #

        $this->makePermission('Доступ в панель администратора', 'admin');

        # Склады #

        $this->makePermission('Склады: просмотр', 'store.get');
        $this->makePermission('Склады: изменение', 'store.update');
        $this->makePermission('Склады: создание', 'store.create');
        $this->makePermission('Склады: удаление', 'store.delete');

        # Другое #
        $this->makePermission('Меню', 'menu');
        
    }

    private function makePermission($name, $code) {
        $permission = new Permission();
        $permission->name = $name;
        $permission->code = $code;
        $permission->save();
    }
}
