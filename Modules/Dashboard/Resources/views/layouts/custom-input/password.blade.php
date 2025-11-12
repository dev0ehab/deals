<div class="form-group position-relative">
    <label for="{{ $name }}"> {{ $label }} </label>
    <input name="{{ $name }}" type="password" class="form-control" value="" id="{{ $name }}"
        class="">
    <small class="form-text text-muted"></small>

    <p class="position-absolute icon">

        <i class="far fa-eye" style="font-size: 18px" id="{{ 'toggle-' . $name }}" data-point='{{ $name }}'></i>
    </p>
</div>

@push('css')
    <style>
        .icon {
            cursor: pointer;
            left: 2%;
            top: 50%;
            transform: translateY(25%);
        }
    </style>
@endpush

@push('js')
    <script>
        $('#toggle-' + `{{ $name }}`).on('click', function(e) {
            $('#' + $('#toggle-' + `{{ $name }}`).data("point")).attr('type', $('#' + $('#toggle-' +
                `{{ $name }}`).data("point")).attr('type') === 'password' ? 'text' : 'password');
            $(this).toggleClass('fa-eye-slash');
        });
    </script>
@endpush
