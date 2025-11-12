{{ BsForm::resource('notifications::notifications')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('notifications::notifications.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('title')->value(request('title')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('message')->value(request('message')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                ->label(trans('notifications::notifications.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('notifications::notifications.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
