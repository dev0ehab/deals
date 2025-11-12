@if(auth()->user()->hasPermission('block_users') && auth()->user()->isNot($user))
    @if (!$user->blocked_at)
        <a href="#user-{{ $user->id }}-block-model"
           class="btn btn-outline-dark waves-effect waves-light btn-sm"
           data-toggle="modal">
            <i class="fa fa-ban"></i>
            @lang('accounts::user.actions.block')
        </a>


        <!-- Modal -->
        <div class="modal fade" id="user-{{ $user->id }}-block-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $user->id }}">@lang('accounts::user.dialogs.block.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('accounts::user.dialogs.block.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::patch(route('dashboard.users.block', $user)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('accounts::user.dialogs.block.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('accounts::user.dialogs.block.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="#user-{{ $user->id }}-unblock-model"
           class="btn btn-outline-dark waves-effect waves-light btn-sm"
           data-toggle="modal">
            <i class="fa fa-check"></i>
            @lang('accounts::user.actions.unblock')
        </a>


        <!-- Modal -->
        <div class="modal fade" id="user-{{ $user->id }}-unblock-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $user->id }}">@lang('accounts::user.dialogs.unblock.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('accounts::user.dialogs.unblock.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::patch(route('dashboard.users.unblock', $user)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('accounts::user.dialogs.unblock.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('accounts::user.dialogs.unblock.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
