{{ BsForm::resource('vendors::vendorss')->get(url()->current()) }}
@component('dashboard::layouts.components.accordion')
    @slot('title', trans('vendors::vendors.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name'))->label(trans('vendors::vendors.attributes.name')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::select('company')->options($companies)->label(__('companies::companies.singular'))->placeholder(__('companies::companies.select')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::text('phone')->value(request('phone'))->label(trans('vendors::vendors.attributes.phone')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::number('perPage')->value(request('perPage', 15))->min(1)->label(trans('vendors::vendors.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('vendors::vendors.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
