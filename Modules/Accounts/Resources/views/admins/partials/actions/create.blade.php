@if(auth()->user()->hasPermission('create_admins'))
    <a href="{{ route('dashboard.admins.create', request()->only('type')) }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('accounts::admins.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('accounts::admins.actions.create')
    </button>
@endif
