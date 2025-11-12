@php
    $notifications = isset($admin) ? $admin->unreadNotifications : auth()->user()->unreadNotifications;
@endphp

<div class="dropdown notification-render d-inline-block">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 45px">
        <i class="mdi mdi-bell-outline"></i>
        @if ($notifications->count() > 0)
            <span class="badge badge-danger badge-pill">{{ $notifications->count() }}</span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 notification-drop"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> {{ __('Notifications') }} </h6>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dashboard.notifications.index') }}" class="small"> {{ __('View All') }}</a>
                </div>
            </div>
        </div>

        <div data-simplebar style="max-height: 230px;">
            @foreach ($notifications as $notification)
                @if (isExist($notification->data['target_type'], $notification->data['target_id']))
                    @php
                        $notificationId = $notification->id;
                    @endphp

                    <a href="{{ $notification->data['url'] }}" onclick="read('{{ $notificationId }}')"
                        class="text-reset notification-item">
                        <div class="media">
                            <img src="{{ $notification->data['sender_image'] }}" class="mr-3 rounded-circle avatar-xs"
                                alt="user-pic">
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">
                                    {{ data_get($notification->data['title'], app()->getLocale(), $notification->data['title']['ar']) }}
                                </h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1">
                                        {{ Str::limit(data_get($notification->data['message'], app()->getLocale(), $notification->data['message']['ar']), 30, '...') }}
                                    </p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>

        <div class="p-2 border-top">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center"
                href="{{ route('dashboard.notifications.index') }}">
                <i class="mdi mdi-arrow-right-circle mr-1"></i> {{ __('View More ..') }}
            </a>
        </div>
    </div>
</div>


<script>
    function read(id) {
        url = "{{ url('api/read/admin/notifications') }}";
        userId = '{{ auth()?->id() }}';
        if (userId) {
            $.ajax({
                type: "POST",
                url: url + `/${userId}`,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "id": id
                },
                success: function(response) {
                    // console.log(response);
                    // $(".notification-render").empty().append(response.messageHtml);
                }
            });
        }
    }

    // window.addEventListener('load', function() {
    //     url = "{{ url('api/dashboard/render-notifications') }}";
    //     $.ajax({
    //         type: "get",
    //         url: url + "/{{ auth()?->id() ?? 0 }}",
    //         success: function(response) {
    //             $(".notification-render").empty().append(response.messageHtml);
    //         }
    //     });
    // });
</script>
