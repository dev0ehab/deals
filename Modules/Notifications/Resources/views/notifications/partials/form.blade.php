@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="custom-control custom-switch mb-4" dir="{{ Locales::getDir() }}">
    <input type="hidden" name="all" value="0">
    <input type="checkbox" name="all" {{ old('all') == 1 ? 'checked' : '' }} value="1" class="custom-control-input"
        id="all">
    <label class="custom-control-label" for="all">@lang('Send to all ?')</label>
</div>

<div id="users">
    <select2 name="users[]" multiple label="@lang('User')" remote-url="{{ route('users.select') }}">
    </select2>
</div>

{{ BsForm::text('title')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}

{{ BsForm::textarea('message')->rows(3)->attribute('class', 'form-control')->attribute(['data-parsley-minlength' => '3']) }}


@push('js')
    <script>
        $(function() {
            $('#all').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#users').css("display", "none");
                } else {
                    $('#users').css("display", "block");
                }
            });
        });
    </script>
@endpush


@push('css')
    <style>
        .select2-selection__choice {
            position: relative !important;
            padding: 2px 0 2px 20px !important;
        }

        .select2-selection__choice__remove {
            background: transparent !important;
            border: 0 !important;
            position: absolute !important;
            left: 5% !important;
        }
    </style>
@endpush
