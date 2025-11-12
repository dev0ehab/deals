{{ BsForm::resource('features::sub_features')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('features::sub_features.actions.filter'))

    <div class="row">
        <div class="col-md-6">
            {{ BsForm::text('name')->value(request('name'))->label(trans('features::sub_features.attributes.name')) }}
        </div>
    
        <div class="col-md-6">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('features::sub_features.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('features::sub_features.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
