<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        // $this->middleware(function ($request, $next) {
        //     $this->user = \Auth::user();
        //     return $next($request);
        // });
    }

    public function adminMenu() {
        $adminMenus = [
            'Dashboard' => [
                'url' => route('admin.dashboard'),
                'title' => 'Dashboard',
                'icon' => '<i class="fa fa-dashboard"></i>',
                'controller' => ['App\Http\Controllers\Admin\DashboardController'],
                'action' => ['admin.dashboard'],
            ],
            'Accounts' => [
                'url' => 'javascript:void(0)',
                'title' => 'Accounts',
                'icon' => '<i class="fa fa-group"></i>',
                'controller' => [
                    'App\Http\Controllers\Admin\RoleController',
                    'App\Http\Controllers\Admin\UserController',
                ],
                'action' => [
                    'admin.users.index','admin.users.create','admin.users.edit',
                    'admin.roles.index','admin.roles.create','admin.roles.edit',
                ],
                'submenu' => [
                    [
                        'url' => route('admin.roles.index'),
                        'title' => 'Roles',
                        'action' => ['admin.roles.index','admin.roles.create','admin.roles.edit'],
                    ],
                    [
                        'url' => route('admin.users.index'),
                        'title' => 'Users',
                        'action' => ['admin.users.index','admin.users.create','admin.users.edit'],
                    ],
                ]
            ],
            'Category' => [
                'url' => 'javascript:void(0)',
                'title' => 'Category',
                'icon' => '<i class="fa fa-list"></i>',
                'controller' => [
                    'App\Http\Controllers\Admin\CategoryController',
                    'App\Http\Controllers\Admin\SubCategoryController',
                ],
                'action' => [
                    'admin.categories.index','admin.categories.create','admin.categories.edit',
                    'admin.sub-categories.index','admin.sub-categories.create','admin.sub-categories.edit',
                ],
                'submenu' => [
                    [
                        'url' => route('admin.categories.index'),
                        'title' => 'Categories',
                        'action' => ['admin.categories.index','admin.categories.create','admin.categories.edit'],
                    ],
                ]
            ],
            'Settings' => [
                'url' => 'javascript:void(0)',
                'title' => 'Settings',
                'icon' => '<i class="fa fa-cog"></i>',
                'controller' => [
                    'App\Http\Controllers\Admin\BannerController',
                ],
                'action' => [
                    'admin.banners.index','admin.banners.create','admin.banners.edit',
                ],
                'submenu' => [
                    [
                        'url' => route('admin.banners.index'),
                        'title' => 'Banners',
                        'action' => ['admin.banners.index','admin.banners.create','admin.banners.edit'],
                    ],
                ]
            ],
        ];
        return $adminMenus;
    }

    public function currentController(){
        $c = Route::getCurrentRoute()->getController();
        return get_class($c);
    }

    public function currentAction(){
        $r = Route::getCurrentRoute()->getAction();//['as'];
        return $r && isset($r['as']) ? $r['as'] : '';
    }
}
