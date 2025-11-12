@extends('dashboard::layouts.default')

@section('title')
    @lang('notifications::notifications.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('notifications::notifications.plural'))
        @slot('breadcrumbs', ['dashboard.notifications.index'])

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('notifications::notifications.actions.list'))

            @slot('tools')
                @if (!auth()->user()->isVendor())
                    @include('notifications::notifications.partials.actions.create')
                @endif
            @endslot

            <thead>
                <tr>
                    <th>@lang('notifications::notifications.attributes.image')</th>
                    <th>@lang('notifications::notifications.attributes.title')</th>
                    <th>@lang('notifications::notifications.attributes.message')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($readNotifications as $notification)
                    @if (isExist($notification->data['target_type'], $notification->data['target_id']))
                        <tr>
                            <td class="d-none d-md-table-cell">
                                <img src="{{ $notification->data['sender_image'] ?? 'https://www.gravatar.com/avatar/454141dab8fba2c55bc2d81247a629a4?d=mm' }}"
                                    class="mr-2 rounded-circle" width="50px" height="50px">
                            </td>
                            <td>
                                {{ $notification->data['title'][app()->getLocale()] }}
                            </td>
                            <td>
                                {{ $notification->data['message'][app()->getLocale()] }}
                            </td>

                            <td style="width: 160px">
                                @include('notifications::notifications.partials.actions.show')
                                @include('notifications::notifications.partials.actions.delete')
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('notifications::notifications.empty')</td>
                    </tr>
                @endforelse

                @if ($readNotifications->hasPages())
                    @slot('footer')
                        {{ $readNotifications->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
