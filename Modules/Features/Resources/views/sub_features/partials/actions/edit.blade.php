@if(auth()->user()->hasPermission('update_sub_features'))
    <a href="{{ route('dashboard.sub_features.edit', [$feature, $sub_feature]) }}"
       class="btn btn-outline-primary waves-effect waves-light btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-icon btn-light-primary btn-hover-primary btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </button>
@endcan
