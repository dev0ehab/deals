@extends('dashboard::layouts.default')

@section('title')
    @lang('accounts::admins.plural')
@endsection

@section('content')

    @component('dashboard::layouts.components.page')
        @slot('title', trans('accounts::admins.plural'))

        @slot('breadcrumbs', ['dashboard.admins.index'])

        @include('accounts::admins.partials.filter')

        @component('dashboard::layouts.components.table-box')

            @slot('title', trans('accounts::admins.actions.list'))

            @slot('tools')
                @include('accounts::admins.partials.actions.create')
            @endslot

            <thead>
            <tr>
                <th>@lang('accounts::admins.attributes.name')</th>
                <th>@lang('accounts::admins.attributes.email')</th>
                {{-- <th>@lang('accounts::admins.attributes.phone')</th> --}}
                {{-- <th>@lang('accounts::admins.attributes.verified')</th> --}}
                <th>@lang('accounts::admins.attributes.created_at')</th>
                <th>...</th>
            </tr>
            </thead>

            <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>
                        <a href="{{ route('dashboard.admins.show', $admin) }}"
                           class="text-decoration-none">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                    <div class="symbol-label"
                                         style="background-image:url({{ $admin->getAvatar() }})"></div>
                                    <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                    @if($admin->blocked_at)
                                        @include('accounts::admins.partials.flags.blocked')
                                    @else
                                        @include('accounts::admins.partials.flags.svg')
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-dark-75 mb-0">
                                        {{ $admin->name }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td>{{ $admin->email }}</td>
                    {{-- <td>{{ $admin->phone }}</td> --}}
                    {{-- <td>@include('accounts::admins.partials.flags.verified')</td> --}}
                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>

                    <td>
                        @include('accounts::admins.partials.actions.show')
                        @include('accounts::admins.partials.actions.edit')
                        @include('accounts::admins.partials.actions.delete')
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="text-center">@lang('accounts::admins.empty')</td>
                </tr>
            @endforelse

            @if($admins->hasPages())
                @slot('footer')
                    {{ $admins->links() }}
                @endslot
            @endif

        @endcomponent

    @endcomponent

@endsection
