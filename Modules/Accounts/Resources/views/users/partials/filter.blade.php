{{ BsForm::resource('accounts::users')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('accounts::user.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name'))->label(trans('accounts::user.attributes.name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('email')->value(request('email'))->label(trans('accounts::user.attributes.email')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('phone')->value(request('phone'))->label(trans('accounts::user.attributes.phone')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('accounts::user.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('accounts::user.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
