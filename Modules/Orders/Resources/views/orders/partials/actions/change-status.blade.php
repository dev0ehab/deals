@php
    $icon = $icon ?? 'fa-check-circle';
    $color = $color ??= 'success';
@endphp

@if (auth()->user()->hasPermission('update_orders'))
    <a href="#order-{{ $order->id ."-". $status }}-status-model"
        class='{{ "btn btn-outline-$color waves-effect waves-light btn-sm" }}' data-toggle="modal">
        <i class='{{ "fas $icon fa fa-fw" }}'></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="order-{{ $order->id ."-". $status }}-status-model" tabindex="-1" role="dialog"
        aria-labelledby="modal-title-{{ $order->id ."-". $status }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $order->id ."-". $status }}">@lang('orders::orders.dialogs.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @lang('orders::orders.dialogs.info', ['status' => __("orders::orders.status." .$status)])
                </div>
                <div class="modal-footer">
                    {{ BsForm::post(route('dashboard.orders.status', $order), ['files' => true, 'data-parsley-validate', 'class' => 'repeater w-100']) }}
                    <input type="hidden" name="status" value="{{ $status }}">

                    @if ($status == 'rejected')
                        <div class="modal-body ">
                            {{ BsForm::textarea('cancel_reason')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3' , 'rows' => '3' , 'cols' => '6'])->label(__('Reason')) }}
                        </div>
                    @endif

                    @if (isset($with_image) && $with_image)
                        @include('dashboard::layouts.apps.file', [
                            'name' => $with_image_name,
                            'mimes' => 'png jpg jpeg',
                            'required' => true,
                        ])
                    @endif

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('orders::orders.dialogs.cancel')
                    </button>
                    <button type="submit" class='{{ "btn btn-$color" }}'>
                        @lang('orders::orders.dialogs.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button type="button" disabled class='{{ "btn btn-outline-$color waves-effect waves-light btn-sm" }}'>
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan
