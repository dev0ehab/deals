@extends('dashboard::layouts.default')

@section('title')
    @lang('advertisements::advertisements.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('advertisements::advertisements.plural'))
        @slot('breadcrumbs', ['dashboard.advertisements.index'])

        @include('advertisements::advertisements.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('advertisements::advertisements.actions.list'))
            @slot('tools')
                @include('advertisements::advertisements.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('advertisements::advertisements.attributes.image')</th>
                    <th>@lang('advertisements::advertisements.attributes.title')</th>
                    <th>@lang('advertisements::advertisements.attributes.active')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advertisements as $advertisement)
                    <tr>
                        <td class="d-none d-md-table-cell">
                            <img src="{{ $advertisement->getImage() }}" class="rounded img-size-64 mr-2" style="height: 64px;">
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $advertisement->title }}
                        </td>

                        <td>
                            @include('dashboard::layouts.apps.activate', [
                                'item' => $advertisement,
                                'url' => 'advertisement/active/',
                            ])
                        </td>

                        <td style="width: 160px">
                            @include('advertisements::advertisements.partials.actions.show')
                            @include('advertisements::advertisements.partials.actions.edit')
                            @include('advertisements::advertisements.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('advertisements::advertisements.empty')</td>
                    </tr>
                @endforelse

                @if ($advertisements->hasPages())
                    @slot('footer')
                        {{ $advertisements->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
