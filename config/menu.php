<?php
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;

/* Fixed navbar landing */
/*
Menu::macro('landing_main', function() {
    return Menu::new()
        ->addClass('nav navbar-nav')
        ->link('#home', trans('adminlte_lang::message.home'))
        ->link('#desc', trans('adminlte_lang::message.description'))
        /*->link('#showcase', trans('adminlte_lang::message.showcase'))
        ->link('#contact', trans('adminlte_lang::message.contact'));
});*/

/*
Menu::macro('landing_auth', function(){
    $menu = Menu::new();

    $menu->addClass('nav navbar-nav navbar-right');
    if (Auth::guest()):
        $menu->link('/login', trans('adminlte_lang::message.login'));
        $menu->link('/register', trans('adminlte_lang::message.register'));
    else:
        $menu->link('/home', Auth::user()->name);
    endif;
    return $menu;
});
*/
/*
Menu::macro('backend_main', function(){
    $menu = Menu::new();
    $menu->addClass('sidebar-menu');

    $menu->html(trans('sidebar.main_header'), ['class' => 'header']);
    $menu->link(url('home'), "<i class='fa fa-home'></i> <span>Inicio</span>");
    $menu->submenu(Link::to('', "<i class='fa fa-users'></i> <span>Pacientes</span>
        <span class='pull-right-container'>
            <i class='fa fa-angle-left pull-right'></i>
        </span>"),
        Menu::new()->addClass('treeview-menu')
        ->link('/paciente/listar', 'Listado')
        ->link('/paciente/nuevo', 'Nuevo')
    )->addClass('treeview');

    $menu->html(trans('sidebar.practica_header'), ['class' => 'header']);
    $menu->submenu(Link::to('',
        "<i class='fa fa-medkit'></i><span>Análisis</span>
        <span class='pull-right-container'>
            <i class='fa fa-angle-left pull-right'></i>
        </span>"),
        Menu::new()->addClass('treeview-menu')
            ->link('/analisis/busqueda', 'Búsqueda')
            ->link('/analisis/nuevo', 'Nuevo')
    )->addClass('treeview');

    if (Auth::user()->hasRole('administrador')):
    $menu->html(trans('sidebar.admin_header'), ['class' => 'header']);
    $menu->submenu(Link::to('', "<i class='fa fa-user-secret'></i> <span>Usuarios</span>
        <span class='pull-right-container'>
            <i class='fa fa-angle-left pull-right'></i>
        </span>"),
        Menu::new()->addClass('treeview-menu')
            ->link('/admin/usuario/listar', 'Listado')
            ->link('/admin/usuario/nuevo', 'Nuevo')
    )->addClass('treeview');
    endif;
    return $menu;
});
*/