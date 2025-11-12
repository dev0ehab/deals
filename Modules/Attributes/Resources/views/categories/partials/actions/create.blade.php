@if(auth()->user()->hasPermission('create_categories'))
    <a href="{{ route('dashboard.categories.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('attributes::categories.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('attributes::categories.actions.create')
    </button>
@endif
