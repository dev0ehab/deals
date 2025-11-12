@extends('dashboard::layouts.default')

@section('title')
    @lang('payments::payments.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('payments::payments.plural'))
        @slot('breadcrumbs', ['dashboard.payments.index'])

        @include('payments::payments.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('payments::payments.actions.list'))
            @slot('tools')
                {{-- @include('payments::payments.partials.actions.create') --}}
            @endslot

            <thead>
            <tr>
                <th>@lang('payments::payments.attributes.name')</th>
                <th>@lang('payments::payments.attributes.active')</th>
                <th>@lang('payments::payments.attributes.created_at')</th>
                <th style="width: 160px">...</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>
                        <a href="{{ route('dashboard.payments.show', $payment) }}"
                           class="text-decoration-none text-ellipsis">
                            {{ $payment->name }}
                        </a>
                    </td>
                    <td>
                        @include('payments::payments.partials.flags.active')
                    </td>
                    <td>
                        {{  $payment->created_at->toDateString() }}
                    </td>
                    <td style="width: 160px">
                        @include('payments::payments.partials.actions.show')
                        @include('payments::payments.partials.actions.edit')
                        {{-- @include('payments::payments.partials.actions.delete') --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="text-center">@lang('payments::payments.empty')</td>
                </tr>
            @endforelse

            @if($payments->hasPages())
                @slot('footer')
                    {{ $payments->links() }}
                @endslot
            @endif
        @endcomponent

    @endcomponent
@endsection
