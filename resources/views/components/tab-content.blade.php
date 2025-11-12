<div id='{{ "tab-$uuid-content" }}' class='tab-content'>

    @foreach (languages() as $locale => $values)

        <div id='{{ "tab-$uuid-$locale" }}' role='tabpanel' aria-labelledby='{{ "tab-$uuid-$locale-tab" }}'
            class="{{ 'tab-pane fade show ' . (app()->getLocale() == $locale ? ' active' : '')}}">

            @stack("$uuid-$locale")

        </div>

    @endforeach
</div>
