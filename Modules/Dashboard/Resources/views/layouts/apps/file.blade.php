
@isset($file)
    <input type='file' @isset ($attributes) {{ $attributes }} @endisset  name='{{ $name }}' class='dropify'  data-default-file='{{ $file }}'  @isset ($mimes) data-allowed-file-extensions='{{ $mimes }}' @endisset />
@else
    <input type='file'  @isset ($attributes) {{ $attributes }} @endisset  name='{{ $name }}' class='dropify'  data-height='200' @isset ($mimes) data-allowed-file-extensions='{{ $mimes }}' @endisset  />
@endisset

@push('js')
    <script>
        $('.dropify').dropify();
    </script>
@endpush
