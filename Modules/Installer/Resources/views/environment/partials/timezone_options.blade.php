@php
    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
@endphp
@foreach($tzlist as $value)
    <option value="{{ $value }}"
            @if ($current_timezone == $value)selected="selected"@endif>{{ $value }}</option>
@endforeach
