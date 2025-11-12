@if(auth()->user()->hasPermission('create_roles'))
    <a href="{{ route('dashboard.roles.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('roles::roles.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('roles::roles.actions.create')
    </button>
@endif
