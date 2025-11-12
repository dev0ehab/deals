@extends('dashboard::layouts.default')

@section('title')
    @lang('accounts::user.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('accounts::user.trashedPlural'))

        @slot('breadcrumbs', ['dashboard.users.trashed'])

        @include('accounts::users.partials.filter')

        @component('dashboard::layouts.components.table-box')

            @slot('title', trans('accounts::user.actions.trashed'))

            @slot('tools')
            @endslot

            <thead>
                <tr>
                    <th>@lang('accounts::user.attributes.name')</th>
                    <th>@lang('accounts::user.attributes.email')</th>
                    <th>@lang('accounts::user.attributes.phone')</th>
                    <th>@lang('accounts::user.attributes.verified')</th>
                    <th>@lang('accounts::user.attributes.created_at')</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('dashboard.users.show', $user) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                        <div class="symbol-label" style="background-image:url({{ $user->getAvatar() }})"></div>
                                        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                        @if ($user->blocked_at)
                                            @include('accounts::users.partials.flags.blocked')
                                        @else
                                            @include('accounts::users.partials.flags.svg')
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>@include('accounts::users.partials.flags.verified')</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>

                        <td style="width: 160px">
                            @include('accounts::users.partials.actions.restore')
                            @include('accounts::users.partials.actions.forceDelete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('accounts::user.empty')</td>
                    </tr>
                @endforelse

                @if ($users->hasPages())
                    @slot('footer')
                        {{ $users->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
