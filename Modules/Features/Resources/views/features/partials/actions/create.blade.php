@if(auth()->user()->hasPermission('create_features'))
    <a href="{{ route('dashboard.features.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('features::features.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('features::features.actions.create')
    </button>
@endif
