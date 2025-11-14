@if(auth()->user()->hasPermission('show_vendors'))
    <a href="{{ route('dashboard.vendors.show', $vendor) }}"
       class="btn btn-outline-warning waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-warning waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </button>
@endcan
