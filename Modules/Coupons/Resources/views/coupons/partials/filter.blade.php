{{ BsForm::resource('coupons::coupons')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('coupons::coupons.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('code')->value(request('code')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::date('start')->value(request('start'))->label(__("coupons::coupons.attributes.start_at")) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::date('expire')->value(request('expire'))->label(__("coupons::coupons.attributes.expire_at")) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('coupons::coupons.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('coupons::coupons.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
