@php
 $route_name = \Route::current()->getName();
@endphp

<!-- Sidebar -->
<div class="sidebar">    
    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header" style="padding-left: 1rem;">MAIN</li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $route_name == 'admin.dashboard' ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>
                Dashboard
            </p>
            </a>
        </li>


        {{-- // CUSTOM MENU MAIN --}}
        @foreach (customMenu()->load() as $menu)
            @if($menu['type'] == 'main-treeview')
                <?php $tr_ada = false; ?>
                @foreach ($menu['menu'] as $item)
                    <?php if (Request::url() == @$item['link']) $tr_ada = true; ?>
                @endforeach
                <li class="nav-item has-treeview {{ $tr_ada ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        @isset($menu['icon'])
                        <i class="fas far {{ $menu['icon'] }} nav-icon"></i>
                        @endisset
                        <p>
                        {!! $menu['name'] !!}
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($menu['menu'] as $item)
                            <li class="nav-item">
                                <a href="{{ @$item['link'] }}" class="nav-link {{ Request::url() == @$item['link'] ? 'active' : '' }}">
                                    <i class="nav-icon fas far {{ @$item['icon'] }}"></i>
                                    <p>
                                    {!! $item['name'] !!}
                                    </p>
                                </a>
                            </li>                            
                        @endforeach
                    </ul>
                </li>
            @elseif($menu['type'] == 'main-normal')
                <li class="nav-item">
                    <a href="{{ @$menu['link'] }}" class="nav-link {{ Request::url() == @$menu['link'] ? 'active' : '' }}">
                        <i class="nav-icon fas far {{ @$menu['icon'] }}"></i>
                        <p>
                        {!! $menu['name'] !!}
                        </p>
                    </a>
                </li>
            @endif
        @endforeach


        
        {{-- // CUSTOM MENU  --}}
        @foreach (customMenu()->load() as $menu)
            @if($menu['type'] == 'treeview')
                <?php $tr_ada = false; ?>
                @foreach ($menu['menu'] as $item)
                    <?php if (Request::url() == @$item['link']) $tr_ada = true; ?>
                @endforeach
                <li class="nav-item has-treeview {{ $tr_ada ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        @isset($menu['icon'])
                        <i class="fas far {{ $menu['icon'] }} nav-icon"></i>
                        @endisset
                        <p>
                        {!! $menu['name'] !!}
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($menu['menu'] as $item)
                            <li class="nav-item">
                                <a href="{{ @$item['link'] }}" class="nav-link {{ Request::url() == @$item['link'] ? 'active' : '' }}">
                                    <i class="nav-icon fas far {{ @$item['icon'] }}"></i>
                                    <p>
                                    {!! $item['name'] !!}
                                    </p>
                                </a>
                            </li>                            
                        @endforeach
                    </ul>
                </li>
            @elseif($menu['type'] == 'normal')
                <li class="nav-item">
                    <a href="{{ @$menu['link'] }}" class="nav-link {{ Request::url() == @$menu['link'] ? 'active' : '' }}">
                        <i class="nav-icon fas far {{ @$menu['icon'] }}"></i>
                        <p>
                        {!! $menu['name'] !!}
                        </p>
                    </a>
                </li>
            @elseif($menu['type'] == 'header')
                <li class="nav-header">{!! $menu['name'] !!}</li>     
            @endif
        @endforeach


        {{-- // MENU PENGATURAN --}}
        @if (env('ADMIN_SETTING_HEADER', true))
        <li class="nav-header">PENGATURAN</li>
        @endif

        {{-- // ALAT --}}
        @if (env('PLUGIN_SETTING_SHOW', true) && env('ADMIN_SETTING_HEADER', true))
            <?php $li = ''; $ada = false; ?>
            @foreach (plugin()->getAllWithInfo(true) as $plugin)
                @php
                    if ($route_name == 'admin.alat.deskripsi' && isset(\Route::current()->parameters['package']) && \Route::current()->parameters['package'] == $plugin->package) $ada = true;
                @endphp
                <?php $li .= '
                <li class="nav-item">
                        <a href="'.route('admin.alat.deskripsi', ['package' => $plugin->package]).'" class="nav-link '.(($route_name == 'admin.alat.deskripsi' && isset(\Route::current()->parameters['package']) && \Route::current()->parameters['package'] == $plugin->package) ? 'active' : '').'">
                            <i class="far fa-circle nav-icon"></i>
                            <p>'.$plugin->name.'</p>
                        </a>
                    </li>'; ?>
            @endforeach
            <li class="nav-item has-treeview {{ ($ada || $route_name == 'admin.alat') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-plug"></i>
                    <p>
                    Alat
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.alat') }}" class="nav-link {{ $route_name == 'admin.alat' ? 'active' : '' }}">
                            <i class="far fa-plus-square nav-icon"></i>
                            <p>Kelola</p>
                        </a>
                    </li>
                    {!! $li !!}
                </ul>
            </li>
        @endif

        {{-- // ADMIN SETTING --}}
        @php
            $tes = customMenu()->load();
            asort($tes);
        @endphp
        @foreach ($tes as $menu)
            @if($menu['type'] == 'setting-treeview')
                <?php $tr_ada = false; ?>
                @foreach ($menu['menu'] as $item)
                    <?php if (Request::url() == @$item['link']) $tr_ada = true; ?>
                @endforeach
                <li class="nav-item has-treeview {{ $tr_ada ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        @isset($menu['icon'])
                        <i class="fas far {{ $menu['icon'] }} nav-icon"></i>
                        @endisset
                        <p>
                        {!! $menu['name'] !!}
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($menu['menu'] as $item)
                            <li class="nav-item">
                                <a href="{{ @$item['link'] }}" class="nav-link {{ Request::url() == @$item['link'] ? 'active' : '' }}">
                                    <i class="nav-icon fas far {{ @$item['icon'] }}"></i>
                                    <p>
                                    {!! $item['name'] !!}
                                    </p>
                                </a>
                            </li>                            
                        @endforeach
                    </ul>
                </li>
            @elseif($menu['type'] == 'setting-normal')
                <li class="nav-item">
                    <a href="{{ @$menu['link'] }}" class="nav-link {{ Request::url() == @$menu['link'] ? 'active' : '' }}">
                        <i class="nav-icon fas far {{ @$menu['icon'] }}"></i>
                        <p>
                        {!! $menu['name'] !!}
                        </p>
                    </a>
                </li>   
            @endif
        @endforeach
    </ul>
    </nav>
</div>