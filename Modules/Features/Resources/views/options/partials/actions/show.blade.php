@if (auth()->user()->hasPermission('show_features'))
    <a href="{{ route('dashboard.options.show', [$feature, $option]) }}"
        class="btn btn-outline-warning waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </a>
@else
    <button type="button" disabled class="btn btn-outline-warning waves-effect waves-light btn-sm">
        <i class="fas fa fa-fw fa-eye"></i>
    </button>
@endcan
