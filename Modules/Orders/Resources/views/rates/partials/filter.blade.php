{{ BsForm::resource('orders::rates')->get(url()->current()) }}


@component('dashboard::layouts.components.accordion')
    @slot('title', trans('orders::rates.actions.filter'))

    <div class="row">


        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('orders::rates.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('orders::rates.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
