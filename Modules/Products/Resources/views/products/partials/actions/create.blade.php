@if(auth()->user()->hasPermission('create_products'))
    <a href="{{ route('dashboard.products.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('products::products.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('products::products.actions.create')
    </button>
@endif
