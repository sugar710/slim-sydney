@if($last > 1)
    <ul class="pagination pagination-sm no-margin pull-right">
        @if(!in_array(1, $roll))
            <li><a href="{{ $page->toPage(1) }}">首页</a></li>
        @endif
        @if($prev)
            <li><a href="{{ $page->toPage($prev) }}">上一页</a></li>
        @else
            <li class="disabled"><a href="javascript:;">上一页</a></li>
        @endif
        @foreach($roll as $num)
            @if($num != $now)
                <li><a href="{{ $page->toPage($num) }}">{{ $num }}</a></li>
            @else
                <li class="active"><a href="javascript:;">{{ $num }}</a></li>
            @endif
        @endforeach
        @if($next)
            <li><a href="{{ $page->toPage($next) }}">下一页</a></li>
        @else
            <li class="disabled"><a href="javascript:;">下一页</a></li>
        @endif
        @if(!in_array($last, $roll))
            <li><a href="{{ $page->toPage($last) }}">尾页</a></li>
    @endif
    <!-- next &raquo; prev &laquo; -->
    </ul>
@endif