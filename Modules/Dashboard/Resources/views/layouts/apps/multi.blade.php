@isset($images)
    <input type="file" name="{{ $name }}" class="dropify" multiple/>
    @include('dashboard::layouts.apps.images', ['images' => $images])
@else
    <input type="file" name="{{ $name }}" class="dropify" data-height="200" multiple/>
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
