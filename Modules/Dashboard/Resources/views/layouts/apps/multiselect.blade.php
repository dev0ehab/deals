<select name="{{ $name }}[]" class="form-control selectpicker" data-live-search="true" data-actions-box="true" multiple>
    @foreach ($data as $id => $text)
        <option value="{{ $id }}"
            @isset($model)
                @if ($in_array(model)) selected @endif
            @endisset>{{ $text }}
        </option>
    @endforeach
</select>
