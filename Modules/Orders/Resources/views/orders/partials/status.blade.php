@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    use App\Enums\OrderStatusEnum;

    switch ($order->status) {
        case OrderStatusEnum::PENDING->value:
            $optionStatus = 'accepted';
            break;

        case OrderStatusEnum::ACCEPTED->value:
            $optionStatus = 'in_preparation';
            break;

        case OrderStatusEnum::IN_PREPARATION->value:
            $optionStatus = 'prepared';
            break;

        case OrderStatusEnum::PREPARED->value:
            $optionStatus = 'under_delivery';
            break;

        case OrderStatusEnum::UNDER_DELIVERY->value:
            $optionStatus = 'completed';
            break;

            default:
            $optionStatus = 'cancelled';
            break;
    }

    $status[$optionStatus] = __("orders::orders.status.$optionStatus");
    $status['cancelled'] = __('orders::orders.status.cancelled');
@endphp

{{ BsForm::select('status')->options($status)->value($order->status)->placeholder(__('Select one'))->attribute('id', 'status')->required() }}

<div id="cancel" style="display: none">
    {{ BsForm::text('cancel_reason')->attribute(['data-parsley-maxlength' => '1050', 'data-parsley-minlength' => '3'])->label(__('Reason')) }}
</div>

@slot('footer')
    {{ BsForm::submit(trans('orders::orders.actions.save'))->attribute('id', 'disable-click') }}
@endslot




@push('js')
    <script>
        $("#status").on('change', function() {
            if ($(this).val() == 'cancelled') {
                $('#cancel').show();
            }else{
                $('#cancel').hide();
            }
        });

        $("form").on('form:submit', function(event) {
            $("#disable-click").attr("disabled", "disabled");
        });
    </script>
@endpush

@push('css')
    <style>
        .accordion>.card {
            overflow: unset;
        }
    </style>
@endpush
