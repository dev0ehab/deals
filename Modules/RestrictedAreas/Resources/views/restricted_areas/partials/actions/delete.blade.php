{{-- @if(auth()->user()->hasPermission('delete_restricted_areas'))
    <a href="#country-{{ $restricted_area->id }}-delete-model" class="btn btn-outline-danger waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="country-{{ $restricted_area->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $restricted_area->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $restricted_area->id }}">@lang('restricted_areas::restricted_areas.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('restricted_areas::restricted_areas.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.restricted_areas.destroy', $restricted_area)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('restricted_areas::restricted_areas.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('restricted_areas::restricted_areas.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-danger waves-effect waves-light btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan --}}
