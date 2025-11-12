@if(auth()->user()->hasPermission('create_restricted_areas'))
    <a href="{{ route('dashboard.restricted_areas.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('restricted_areas::restricted_areas.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('restricted_areas::restricted_areas.actions.create')
    </button>
@endif
