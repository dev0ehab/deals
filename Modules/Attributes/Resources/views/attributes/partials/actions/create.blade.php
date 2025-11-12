@if(auth()->user()->hasPermission('create_attributes'))
    <a href="{{ route('dashboard.attributes.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('attributes::attributes.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('attributes::attributes.actions.create')
    </button>
@endif
