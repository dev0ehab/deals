{{ BsForm::resource('orders::orders')->get(url()->current()) }}

@php
    use App\Enums\OrderStatusEnum;

    collect(OrderStatusEnum::values())->map(function ($status) use(&$statuses) {
        return $statuses[$status] = trans("orders::orders.status.{$status}");
    });

@endphp
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('orders::orders.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('id')->value(request('id')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::text('phone')->value(request('phone')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::text('email')->value(request('email')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::select('status')->label(trans("orders::orders.attributes.status"))->options($statuses)->placeholder(__("Select one")) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('orders::orders.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('orders::orders.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
