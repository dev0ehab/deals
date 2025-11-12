@isset($file)
    <input type="file" name="{{ $name }}" class="dropify" data-height="180" data-default-file="{{ $file }}" />
@else
    <input type="file" name="{{ $name }}" class="dropify" data-height="180" data-max-file-size="5M"/>
@endisset
@include('dashboard::seo.inputs')

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
