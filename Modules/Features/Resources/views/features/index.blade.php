@extends('dashboard::layouts.default')

@section('title')
    @lang('features::features.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('features::features.plural'))
        @slot('breadcrumbs', ['dashboard.features.index'])
{{--
        @include('dashboard::layouts.apps.module-activate', [
            'model' => "Feature",
        ]) --}}

        @include('features::features.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('features::features.actions.list'))
            @slot('tools')
                @include('features::features.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('features::features.attributes.image')</th>
                    <th>@lang('features::features.attributes.name')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ $feature->image }}" alt="Product 1" class="mr-2 rounded" width="64" height="64">
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $feature->name }}
                        </td>

                        <td style="width: 160px">
                            @include('features::features.partials.actions.show')
                            @include('features::features.partials.actions.edit')
                            @include('features::features.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('features::features.empty')</td>
                    </tr>
                @endforelse

                @if ($features->hasPages())
                    @slot('footer')
                        {{ $features->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
