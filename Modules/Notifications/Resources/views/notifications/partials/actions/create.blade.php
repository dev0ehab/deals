@if(auth()->user()->hasPermission('create_notifications'))
    <a href="{{ route('dashboard.notifications.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('notifications::notifications.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('notifications::notifications.actions.create')
    </button>
@endif
