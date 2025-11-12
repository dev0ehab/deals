@if(auth()->user()->hasPermission('delete_addresses'))
    <a href="#address-{{ $address->id }}-delete-model"
       class="btn btn-icon btn-light-danger btn-hover-danger btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="address-{{ $address->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $address->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $address->id }}">@lang('addresses::addresses.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('addresses::addresses.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.customers.addresses.destroy', [$customer, $address])) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('addresses::addresses.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('addresses::addresses.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@endcan
