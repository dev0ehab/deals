@if(auth()->user()->hasPermission('create_areas'))
    <a href="{{ route('dashboard.areas.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('areas::areas.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('areas::areas.actions.create')
    </button>
@endif
