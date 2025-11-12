@extends('dashboard::layouts.default')

@section('title')
    @lang('areas::areas.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('areas::areas.plural'))
        @slot('breadcrumbs', ['dashboard.areas.index'])

        @include('areas::areas.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('areas::areas.actions.list'))
            @slot('tools')
                @include('areas::areas.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('areas::areas.attributes.name')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areas as $area)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            {{ $area->name }}
                        </td>

                        <td style="width: 160px">
                            @include('areas::areas.partials.actions.show')
                            @include('areas::areas.partials.actions.edit')
                            @include('areas::areas.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('areas::areas.empty')</td>
                    </tr>
                @endforelse

                @if ($areas->hasPages())
                    @slot('footer')
                        {{ $areas->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
