@extends('dashboard::layouts.default')

@section('title')
    @lang('accounts::user.plural')
@endsection

@section('content')

    @component('dashboard::layouts.components.page')
        @slot('title', trans('accounts::user.plural'))

        @slot('breadcrumbs', ['dashboard.users.index'])

        @include('accounts::users.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('accounts::user.actions.list'))

            @slot('tools')
                @include('accounts::users.partials.actions.trashed')
            @endslot

            <thead>
                <tr>
                    <th>@lang('accounts::user.attributes.name')</th>
                    <th>@lang('accounts::user.attributes.phone')</th>
                    <th>@lang('accounts::user.attributes.email')</th>
                    <th>@lang('accounts::user.attributes.verified')</th>
                    <th>@lang('accounts::user.attributes.status')</th>
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
                                        <img src="{{ $user->getAvatar() }}" width="40" class="rounded-circle">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>@include('accounts::users.partials.flags.verified')</td>
                        <td>@include('accounts::users.partials.flags.blocked')</td>

                        <td>
                            @include('accounts::users.partials.actions.show')
                            {{-- @include('accounts::users.partials.actions.edit') --}}
                            @include('accounts::users.partials.actions.delete')
                            @include('accounts::users.partials.actions.block')

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
