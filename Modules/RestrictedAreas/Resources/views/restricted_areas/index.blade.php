@extends('dashboard::layouts.default')

@section('title')
    @lang('restricted_areas::restricted_areas.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('restricted_areas::restricted_areas.plural'))
        @slot('breadcrumbs', ['dashboard.restricted_areas.index'])

        @include('restricted_areas::restricted_areas.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('restricted_areas::restricted_areas.actions.list'))
            @slot('tools')
                @include('restricted_areas::restricted_areas.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('restricted_areas::restricted_areas.attributes.name')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($restricted_areas as $restricted_area)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            {{ $restricted_area->name }}
                        </td>

                        <td style="width: 160px">
                            @include('restricted_areas::restricted_areas.partials.actions.show')
                            @include('restricted_areas::restricted_areas.partials.actions.edit')
                            @include('restricted_areas::restricted_areas.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('restricted_areas::restricted_areas.empty')</td>
                    </tr>
                @endforelse

                @if ($restricted_areas->hasPages())
                    @slot('footer')
                        {{ $restricted_areas->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
