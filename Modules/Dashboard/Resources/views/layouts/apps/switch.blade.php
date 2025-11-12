<div class="form-group col-6">
    <div class="custom-control custom-switch my-4" dir="{{ Locales::getDir() }}">
        <input type="hidden" name="{{ $name }}" value="0">
        @isset($item)
            <input  type="checkbox"
                    name="{{ $name }}"
                    value="1"
                    class="custom-control-input"
                    id="{{ $name }}"
                    {{ $checked  ? 'checked' : '' }}>
        @else
            <input  type="checkbox"
                    name="{{ $name }}"
                    value="1" checked
                    class="custom-control-input"
                    id="{{ $name }}">
        @endisset

        <label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
