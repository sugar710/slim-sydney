@if($hasMenu = isset($menu["items"]))
    <li class="treeview">
        <a href="javascript:;">
            <i class="fa fa-folder"></i>
            <span>{{ $menu['name'] }}</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            @each('adm.layout-sidebar-item', $menu['items'], 'menu')
        </ul>
    </li>
@else
    <li>
        <a @if($router = $menu['router']) href="{{ admUrl($router['path'], $router['query']) }}"
           @else href="javascript:;" @endif>
            <i class="fa fa-circle-o"></i>
            <span>{{ $menu['name'] }}</span>
        </a>
    </li>
@endif