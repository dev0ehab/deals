@extends('dashboard::layouts.default')

@section('title')
    @lang('Notifications')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('Notifications'))
        @slot('breadcrumbs', ['dashboard.blogs.index'])

        {{-- @include('blogs::blogs.partials.filter') --}}

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('All Notifications'))
            @slot('tools')
                {{-- @include('blogs::blogs.partials.actions.create') --}}
            @endslot

            <thead>
                <tr>
                    <th>@lang('User Image')</th>
                    <th>@lang('Title')</th>
                    <th>@lang('Content')</th>
                    {{-- <th style="width: 160px">...</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($readNotifications as $notification)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ $notification->data['user_image'] }}" alt="Product 1" class="mr-2" style="height: 64px;">
                        </td>
                        <td>
                            {{ $notification->data['title'] }}
                        </td>
                        <td>
                            {{ $notification->data['message'] }}
                        </td>


                        {{-- <td style="width: 160px">
                            @include('blogs::blogs.partials.actions.show')
                            @include('blogs::blogs.partials.actions.edit')
                            @include('blogs::blogs.partials.actions.delete')
                        </td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('No Notifications Yet.')</td>
                    </tr>
                @endforelse

                @slot('footer')
                    {{ $readNotifications->links() }}
                @endslot
            @endcomponent
        @endcomponent
    @endsection
