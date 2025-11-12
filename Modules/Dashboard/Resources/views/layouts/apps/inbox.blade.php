<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">{{ __("Inbox") }}</h4>

        <ul class="inbox-wid list-unstyled">

            @foreach ($messages as $message)
                <li class="inbox-list-item">
                    <a href="{{ route('dashboard.contact-us.show', $message->id) }}">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <h5 class="font-size-16 mb-1">{{ $message->name }}</h5>
                                <p class="text-truncate mb-0">{{ Str::limit($message->message, 30, '..') }}</p>
                            </div>
                            <div class="font-size-12 ml-2">
                                {{ $message->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="text-center">
            <a href="{{ route('dashboard.contact-us.index') }}" class="btn btn-primary btn-sm">{{ __("load more") }}</a>
        </div>
    </div>
</div>
