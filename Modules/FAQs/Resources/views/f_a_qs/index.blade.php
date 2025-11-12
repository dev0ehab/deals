@extends('dashboard::layouts.default')

@section('title')
    @lang('f_a_qs::f_a_qs.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('f_a_qs::f_a_qs.plural'))
        @slot('breadcrumbs', ['dashboard.f_a_qs.index'])

        @include('f_a_qs::f_a_qs.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('f_a_qs::f_a_qs.actions.list'))
            @slot('tools')
                @include('f_a_qs::f_a_qs.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('f_a_qs::f_a_qs.attributes.question')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($f_a_qs as $f_a_q)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            {{ $f_a_q->question }}
                        </td>
                        <td style="width: 160px">
                            @include('f_a_qs::f_a_qs.partials.actions.show')
                            @include('f_a_qs::f_a_qs.partials.actions.edit')
                            @include('f_a_qs::f_a_qs.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('f_a_qs::f_a_qs.empty')</td>
                    </tr>
                @endforelse

                @if ($f_a_qs->hasPages())
                    @slot('footer')
                        {{ $f_a_qs->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
