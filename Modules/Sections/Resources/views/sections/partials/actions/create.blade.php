@if(auth()->user()->hasPermission('create_sections'))
    <a href="{{ route('dashboard.sections.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('sections::sections.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('sections::sections.actions.create')
    </button>
@endif
