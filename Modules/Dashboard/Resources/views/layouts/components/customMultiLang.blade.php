@php
    $uuid = uniqid();
    $index = 0;
@endphp


<label for=""> {{ $label ??= '' }}</label>
@foreach (languages() as $locale => $values)
    @push("$uuid-$locale")
        <div class="w-100" data-repeat-list='{{ "$uuid-$locale" }}'>
            @include($component, ['name' => $name, 'model' => $model ??= null])
        </div>
    @endpush
@endforeach



<div class="card-body ">

    @include('components.tab-item')

    @include('components.tab-content')

</div>
