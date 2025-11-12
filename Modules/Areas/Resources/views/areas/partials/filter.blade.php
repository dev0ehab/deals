{{ BsForm::resource('areas::areas')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('areas::areas.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                ->label(trans('areas::areas.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('areas::areas.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
