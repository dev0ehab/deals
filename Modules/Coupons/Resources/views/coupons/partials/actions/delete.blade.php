@if(auth()->user()->hasPermission('delete_coupons'))
    <a href="#coupon-{{ $coupon->id }}-delete-model"
       class="btn btn-outline-danger waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="coupon-{{ $coupon->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $coupon->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $coupon->id }}">@lang('coupons::coupons.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('coupons::coupons.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.coupons.destroy', $coupon)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('coupons::coupons.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-outline-danger">
                        @lang('coupons::coupons.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    {{-- <button
        type="button"
        disabled
        class="btn btn-icon btn-light-danger btn-hover-danger btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button> --}}
@endif
