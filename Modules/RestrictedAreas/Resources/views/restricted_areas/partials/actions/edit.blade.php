@if(auth()->user()->hasPermission('update_restricted_areas'))
    <a href="{{ route('dashboard.restricted_areas.edit', $restricted_area) }}"
       class="btn btn-outline-primary waves-effect waves-light btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-primary waves-effect waves-light btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </button>
@endcan
