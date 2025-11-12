@isset($file)
    <input type="file" name="{{ $name }}" class="dropify" data-allowed-file-extensions="mp4 webm" data-default-file="{{ $file }}" />
@else
    <input type="file" name="{{ $name }}" class="dropify" data-allowed-file-extensions="mp4 webm" data-height="200" multiple />
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
