@if(auth()->user()->hasPermission('forceDelete_vendors'))
    <a href="#vendor-{{ $vendor->id }}-delete-model" class="btn btn-outline-danger waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="vendor-{{ $vendor->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $vendor->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $vendor->id }}">@lang('vendors::vendorsdialogs.force.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('vendors::vendorsdialogs.force.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::get(route('dashboard.vendors.forceDelete', $vendor)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('vendors::vendorsdialogs.force.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('vendors::vendorsdialogs.force.confirm')
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
@endcan
