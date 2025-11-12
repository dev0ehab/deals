@if((isset($can['permission'])
    && auth()->user()->isAbleTo([$can['permission']]))
    || ! isset($can))

    <li class="{{ isset($isActive) && $isActive ?  'mm-active' : '' }}">
        <a href="{{ isset($tree) && is_array($tree) ? 'javascript: void(0);' : ($url ?? '#') }}"
           class="{{ isset($tree) && is_array($tree) ? 'has-arrow' : '' }} waves-effect {{ isset($isActive) && $isActive ?  'active' : '' }}">
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            <span>{{ $name }}</span>
        </a>
        @if(isset($tree) && is_array($tree) && count($tree))
            <ul class="sub-menu" aria-expanded="false">
                @foreach($tree as $item)
                    @if(isset($item['module']) && \Module::collections()->has($item['module']))
                        @if((isset($item['can']['permission'])
                        && auth()->user()->isAbleTo($item['can']['permission']))
                        || ! isset($item['can']))
                            <li class="{{ isset($item['isActive']) && $item['isActive'] ? ' mm-active' : '' }}">
                                <a href="{{ isset($item['tree']) && is_array($item['tree']) ? 'javascript: void(0);' : ($item['url'] ?? '#') }}"
                                   class="{{ isset($item['tree']) && is_array($item['tree']) ? 'has-arrow' : '' }} waves-effect {{ isset($item['isActive']) && $item['isActive'] ?  'active' : '' }}">
                                    @isset($item['icon'])
                                        <i class="{{ $item['icon'] }}"></i>
                                    @endisset
                                    {{ $item['name'] }}
                                </a>
                                {{-- second tree --}}
                                @if(isset($item['tree']) && is_array($item['tree']) && count($item['tree']))
                                    <ul class="sub-menu" aria-expanded="false">
                                        @foreach($item['tree'] as $treeItem)
                                            @if(isset($treeItem['module']) && \Module::collections()->has($treeItem['module']))
                                                @if((isset($treeItem['can']['permission'])
                                                && auth()->user()->isAbleTo($treeItem['can']['permission']))
                                                || ! isset($treeItem['can']))
                                                    <li class="{{ isset($treeItem['isActive']) && $treeItem['isActive'] ? ' mm-active' : '' }}">
                                                        <a href="{{ $treeItem['url'] }}">
                                                            @isset($treeItem['icon'])
                                                                <i class="{{ $treeItem['icon'] }}"></i>
                                                            @endisset
                                                            {{ $treeItem['name'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                {{-- second tree --}}
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
@endif
