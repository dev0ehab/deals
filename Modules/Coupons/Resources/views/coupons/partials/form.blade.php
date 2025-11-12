@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{ BsForm::text('code')->required()->attribute([isset($coupon) ? 'disabled' : ''])->value(isset($coupon) ? $coupon->code : old('code')) }}

@bsMultilangualFormTabs
    {{ BsForm::textarea('description')->required()->attribute(['class' => 'form-control textarea', 'data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
@endBsMultilangualFormTabs


{{ BsForm::select('discount_type')->attribute([isset($coupon) ? 'disabled' : ''])->options([
        'delivery' => __('coupons::coupons.options.discount_type.delivery'),
        'total' => __('coupons::coupons.options.discount_type.total'),
    ])->placeholder(__('coupons::coupons.messages.select_one'))->required() }}


<div id="coupon-type-group" style="display: none;">
    <div class="form-group">
        <label>Coupon Type</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="coupon_type" id="coupon_type_percent" value="percent"
                {{ (isset($coupon) && $coupon->coupon_type == 'percent') || (!isset($coupon) && old('coupon_type', 'percent') == 'percent') ? 'checked' : '' }}>
            <label class="form-check-label" for="coupon_type_percent">
                Percent
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="coupon_type" id="coupon_type_fixed" value="fixed"
                {{ (isset($coupon) && $coupon->coupon_type == 'fixed') || (!isset($coupon) && old('coupon_type') == 'fixed') ? 'checked' : '' }}>
            <label class="form-check-label" for="coupon_type_fixed">
                Fixed
            </label>
        </div>
    </div>
</div>

<div id="discount-fields" style="display: none;">
    <div id="percentage-discount-field">
        {{ BsForm::number('percentage_discount')->min(1)->max(100)->step(1)->required() }}
    </div>
    <div id="max-discount-field">
        {{ BsForm::number('max_discount')->min(1)->step(1)->required() }}
    </div>
</div>

<div class="row">
    <div class="col-6">
        {{ BsForm::number('max_usage_per_user')->min(1)->step(1)->required() }}
    </div>
    <div class="col-6">
        {{ BsForm::number('max_usage')->min(1)->step(1)->required() }}
    </div>
</div>

<div class="row">
    <div class="col-6">
        {{ BsForm::number('first_order_count')->min(1)->step(1)->placeholder(__('coupons::coupons.messages.leave_empty_for_unlimited')) }}
    </div>
    <div class="col-6">
        <!-- Empty column for layout balance -->
    </div>
</div>

<div class="row">
    <div class="col-6">
        @isset($coupon)
            <label>@lang('coupons::coupons.attributes.start_at')</label>
            <input type="date" name="start_at" class="form-control" value="{{ $coupon->start_at->toDateString() }}"
                readonly>
        @else
            {{ BsForm::date('start_at')->value(optional($coupon->start_at ?? null)->toDateString())->required()->attribute(['placeholder' => __('coupons::coupons.messages.date_format_placeholder')]) }}
        @endisset
    </div>
    <div class="col-6">
        {{ BsForm::date('expire_at')->value(optional($coupon->expire_at ?? null)->toDateString())->required()->attribute(['placeholder' => __('coupons::coupons.messages.date_format_placeholder')]) }}
    </div>
</div>

{{ BsForm::select('audience')->options([
        'all' => __('coupons::coupons.options.audience.all'),
        'specific' => __('coupons::coupons.options.audience.specific'),
    ])->attribute(['id' => 'audience', isset($coupon) && $coupon->audience == 'all' ? 'disabled' : ''])->placeholder(__('coupons::coupons.messages.select_one')) }}


@if (isset($coupon) && $coupon->audience == 'all')
    {!! Form::hidden('audience', 'all') !!}
@endif

<div id="users"
    @isset($coupon)
        @if ($coupon->audience == 'all')
            style="display: none"
        @endif
    @else
        style="display: none"
    @endisset>

    <select2 name="users[]" multiple label="@lang('coupons::coupons.attributes.user')"
        @isset($coupon)
            @if ($coupon->audience == 'all')
                :value="{{ json_encode([]) }}"
            @else
                :value="{{ json_encode($coupon->users) ?? old('users') }}"
            @endif
        @endisset
        remote-url="{{ route('users.select') }}"> </select2>
</div>

@push('js')
    <script>
        $('#audience').on('change', function() {
            if ($(this).val() == 'specific') {
                $('#users').css("display", "block");
            } else {
                $('#users').css("display", "none");
            }
        });

        // Handle discount type change
        $('select[name="discount_type"]').on('change', function() {
            if ($(this).val() == 'delivery') {
                $('#discount-fields').hide();
                $('#coupon-type-group').hide();
            } else {
                $('#coupon-type-group').show();
                toggleCouponFields();
            }
        });

        // Handle coupon type radio button change
        $('input[name="coupon_type"]').on('change', function() {
            toggleCouponFields();
        });

        // Function to toggle fields based on coupon type
        function toggleCouponFields() {
            var couponType = $('input[name="coupon_type"]:checked').val();
            $('#max-discount-field').show(); // Always show max_discount
            if (couponType == 'percent') {
                $('#percentage-discount-field').show();
                $('#discount-fields').show();
            } else if (couponType == 'fixed') {
                $('#percentage-discount-field').hide();
                $('#discount-fields').show();
            }
        }

        // Initialize on page load
        $(document).ready(function() {
            var discountType = $('select[name="discount_type"]').val();
            if (discountType == 'delivery') {
                $('#discount-fields').hide();
                $('#coupon-type-group').hide();
            } else {
                $('#coupon-type-group').show();
                // Initialize based on existing coupon type or default
                toggleCouponFields();
            }
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
