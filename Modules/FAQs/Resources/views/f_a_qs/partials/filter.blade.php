{{ BsForm::resource('f_a_qs::f_a_qs')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('f_a_qs::f_a_qs.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('question')->value(request('question')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('answer')->value(request('answer')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                ->label(trans('f_a_qs::f_a_qs.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('f_a_qs::f_a_qs.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
