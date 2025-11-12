
<ul id='{{ "tab-$uuid"}}' role='tablist' class='nav nav-tabs'>

    @foreach (languages() as $locale => $values)

        <li class='nav-item'>

            <a id='{{ "tab-$uuid-$locale-tab"}}' data-toggle='tab' href='{{"#tab-$uuid-$locale"}}' role='tab'
                aria-controls='{{"tab-$uuid-$locale"}}' aria-selected='true'
                class="{{ 'nav-link ' . (app()->getLocale() == $locale ? ' active' : '')}}">

                <img src="{{ url($values->flag) }}" alt='' class='mx-1'>
                {{ __($values->name) }}
            </a>
        </li>
    @endforeach

</ul>
