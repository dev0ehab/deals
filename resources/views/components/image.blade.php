<div data-type="textarea" style="flex-wrap: unset" class="row my-2" data-row='{{ "$uuid-$index" }}' data-row-index="{{ $index }}"
    data-repeat="{{ $uuid }}" data-locale='{{ $locale }}'>
    <label for="">{{ $label }}</label>
    <div class='col-10'>
        <div class='form-group'>
            <input type="hidden" name='{{ $name . "[$index]" . '[id]' }}' value="{{ $model?->id }}">

            <textarea class="form-control textarea" name='{{ $name . "[$index]" . "[$name:$locale]" }}'
                id='{{ $name . "[$index]" . "[$name:$locale]" }}'
                value="{{ old($name . "[$index]" . "[$name:$locale]", $model?->translate($locale)?->$name) }}">{{ $model?->$name }}</textarea>

            <small class='form-text text-muted'></small>
        </div>
    </div>

    <div data-row-index="{{ $index }}"
        class='{{ 'col-2 del ' . "$uuid-delete-button " . ($index == 0 ? 'd-none' : 'd-block') }}'>
        <button type="button" data-delete='{{ "$uuid-$index" }}' class="btn btn-danger">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>




<style>
    .del {
        margin-top: 1.1rem;
    }
</style>

