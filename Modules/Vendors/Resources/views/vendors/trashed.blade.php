@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendorsplural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('vendors::vendorstrashedPlural'))

        @slot('breadcrumbs', ['dashboard.vendors.trashed'])

        @include('vendors::vendorspartials.filter')

        @component('dashboard::layouts.components.table-box')

            @slot('title', trans('vendors::vendorsactions.trashed'))

            @slot('tools')
            @endslot

            <thead>
                <tr>
                    <th>@lang('vendors::vendorsattributes.name')</th>
                    <th>@lang('vendors::vendorsattributes.phone')</th>
                    <th>@lang('vendors::vendorsattributes.verified')</th>
                    <th>@lang('companies::companies.singular')</th>
                    <th>...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td>
                            <a href="{{ route('dashboard.vendors.show', $vendor) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                        <div class="symbol-label" style="background-image:url({{ $vendor->getAvatar() }})"></div>
                                        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                        @if ($vendor->blocked_at)
                                            @include('vendors::vendorspartials.flags.blocked')
                                        @else
                                            @include('vendors::vendorspartials.flags.svg')
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $vendor->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $vendor->phone }}</td>
                        <td>@include('vendors::vendorspartials.flags.verified')</td>
                        <td>{{ $vendor->company->name }}</td>
                        <td>{{ $vendor->created_at->format('Y-m-d') }}</td>

                        <td style="width: 160px">
                            @include('vendors::vendorspartials.actions.restore')
                            {{-- @include('vendors::vendorspartials.actions.forceDelete') --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('vendors::vendorsempty')</td>
                    </tr>
                @endforelse

                @if ($vendors->hasPages())
                    @slot('footer')
                        {{ $vendors->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
