@foreach(Locales::get() as $locale)
    <option value="{{ $locale->code }}"
            @if ($selected == $locale->code)selected="selected"@endif>{{ $locale->name }}</option>
@endforeach
