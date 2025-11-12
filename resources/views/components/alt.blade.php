<div class="row my-2" data-row='{{ "$uuid" }}' data-row-index="{{ $index }}" data-repeat="{{ $uuid }}"
    data-locale='{{ $locale }}'>
    <label for="">{{ $label }}</label>
    <div class='col-10'>
        <div class='form-group'>
            <input {!! $attributes ??= "required  type='text'" !!} name='{{ $name . "[$locale]" }}'
                id='{{ $name . "[$name][$locale]" }}'
                value="{{ old($name . "[$name][$locale]", data_get($model , $locale))}}"
                class='form-control'>

            <small class='form-text text-muted'></small>
        </div>
    </div>

    {{-- <div data-row-index="{{ $index }}"
        class='{{ 'col-2 del ' . "$uuid-delete-button " . ($index == 0 ? 'd-none' : 'd-block') }}'>
        <button type="button" data-delete='{{ "$uuid" }}' class="btn btn-danger">
            <i class="fa fa-trash"></i>
        </button>
    </div> --}}
</div>




<style>
    .del {
        margin-top: 1.1rem;
    }
</style>
