<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::guard('admin')->user()->avatar?:'/packages/admin/images/avatar.jpg' }}"  width="" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>AdminName</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> online </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">菜单</li>
            <?php $menus = request()->get('menus')?>
            @forelse ($menus as $menu )
                @if ( !empty($menu['child']) )
                <li class="{{ !empty($menu['active'])?$menu['active']:'' }}" >
                <a href="#">
                    <i class="fa {{ $menu['icon'] }}"></i>
                    <span>{{ $menu['name'] }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                    @if ( !empty($menu['child']) )
                        <ul class="treeview-menu">
                            @foreach($menu['child'] as $branchMenu)
                                <li class="treeview {{ !empty($branchMenu['active'])?$branchMenu['active']:'' }}">
                                    <a href="{{ route($branchMenu['uri']) }}"><i class="fa {{ $branchMenu['icon'] }}"></i>
                                        <span>{{ $branchMenu['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    @else
                    @endif
                </li>
                @endif
            @empty
            @endforelse

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

