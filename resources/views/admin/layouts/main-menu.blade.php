<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('assets/admin/adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @if( $adminMenu )
            @foreach( $adminMenu as $menu )

                 {{-- @if ( $user->isAdmin || ( isset($menu['permissions'])
                && $user->permissions && App\Helpers\StringHelper::in_array($menu['permissions'], $user->permissions) ) ) --}}

                    <li class="<?= isset($menu['controller']) && in_array($currentController, $menu['controller']) ? 'active' : '' ?> <?= isset($menu['submenu']) ? 'treeview' : '' ?>">
                        <a class="<?= isset($menu['action']) && in_array($currentAction, $menu['action']) ? 'active' : '' ?>" href="{!! $menu['url'] !!}">
                            {!! $menu['icon'] !!}
                            <span>{!! $menu['title'] !!}</span>

                            @if( isset($menu['submenu']) )
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            @endif
                        </a>

                        @if( isset($menu['submenu']) )
                            <ul class="treeview-menu">
                                @foreach( $menu['submenu'] as $submenu )
                                    {{-- @if ( $user->isAdmin || (isset($submenu['permissions']) && $user->permissions && App\Helpers\StringHelper::in_array($submenu['permissions'], $user->permissions)) ) --}}
                                        <li class="<?= isset($submenu['action']) && in_array($currentAction, $submenu['action']) ? 'active' : '' ?>">
                                            <a href="{!! $submenu['url'] !!}">
                                                <i class="fa fa-angle-double-right"></i>
                                                {!! $submenu['title'] !!}
                                            </a>
                                        </li>
                                    {{--@endif--}}
                                @endforeach
                            </ul>
                        @endif
                    </li>
                {{--@endif--}}
            @endforeach
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>