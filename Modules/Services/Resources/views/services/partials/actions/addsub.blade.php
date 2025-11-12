@if(auth()->user()->hasPermission('read_services'))
    <a href="{{ route('dashboard.services.create', 'id='.$service->id) }}"
       class="btn btn-outline-success waves-effect waves-light btn-sm">
        <i class="fas fa-stream"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-icon btn-light-primary btn-hover-primary btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </button>
@endcan
