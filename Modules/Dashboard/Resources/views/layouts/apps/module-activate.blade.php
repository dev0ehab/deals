    @php
        use Laraeast\LaravelSettings\Facades\Settings;
        $isChecked = Settings::get($model, false);
    @endphp
    <div class="toggle-parent p-2 d-flex justify-content-start align-items-center" style="gap: 2.5rem">
        <label for="module-activation" style="font-size: 1.5rem">{{ __('Show In Landing Page') }}</label>
        <input id='module-activation' type="checkbox" {{ $isChecked ? 'checked' : '' }} data-toggle="toggle" data-size="lg"
            data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" data-onstyle="outline-success" data-offstyle="outline-danger">
    </div>


    @push('js')
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script src="{{ asset('assets/js/notify.min.js') }}"></script>
        <script>
            const url = "{{ url('api/activate-model') }}";
            const model = "{{ $model }}";
            $('#module-activation').change(function() {
                var status = $("#module-activation").is(':checked') ? 1 : 0;
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        model: model,
                        status: status
                    },
                    dataType: "json",
                    success: function(response) {

                        $msg = response.active ? "{{ __('Module Has Been Activated') }}" :
                            "{{ __('Module Has Been Deactivated') }}"

                        $.notify($msg, "success");
                    }

                })
            });
        </script>
    @endpush


    @push('css')
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
            rel="stylesheet">
        <style>
            @media (max-width: 991px) {
                .toggle-parent {
                    padding-top: 35px !important;
                }
            }
        </style>
    @endpush
