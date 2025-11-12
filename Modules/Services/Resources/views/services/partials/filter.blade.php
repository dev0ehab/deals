{{ BsForm::resource('services::services')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('services::services.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name'))->label(trans('services::services.attributes.name')) }}
        </div>
    
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('services::services.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('services::services.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
