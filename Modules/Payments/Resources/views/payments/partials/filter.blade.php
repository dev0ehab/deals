{{ BsForm::resource('payments::payments')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('payments::payments.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('payments::payments.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('payments::payments.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
