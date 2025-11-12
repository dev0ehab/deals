<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">{{ __('Notifications') }}</h4>

        <ul class="inbox-wid list-unstyled">
            @foreach (auth()->user()->unreadNotifications->take(3) as $notification)
                @if (isExist($notification->data['target_type'], $notification->data['target_id']))
                    <li class="inbox-list-item">
                        <a href="{{ $notification->data['url'] }}">
                            <div class="media">
                                <img src="{{ $notification->data['sender_image'] }}" class="mr-3 rounded-circle avatar-xs"
                                alt="user-pic">
                                <div class="media-body overflow-hidden">
                                    <h5 class="font-size-16 mb-1">{{ $notification->data['title'][app()->getLocale()] }}</h5>
                                    <p class="text-truncate mb-0">
                                        {{ Str::limit($notification->data['message'][app()->getLocale()], 50, '..') }}</p>
                                </div>
                                <div class="font-size-12 ml-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <div class="text-center">
            <a href="{{ route('dashboard.notifications.index') }}"
                class="btn btn-primary btn-sm">{{ __('load more') }}</a>
        </div>
    </div>
</div>
