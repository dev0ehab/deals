@extends('dashboard::layouts.default')

@section('title')
    @lang('services::services.plural')
@endsection

@section('content')

    @component('dashboard::layouts.components.page')
        @slot('title', trans('services::services.plural'))

        @slot('breadcrumbs', ['dashboard.services.index'])

        @include('services::services.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('services::services.actions.main'))
            @slot('tools')
                @include('services::services.partials.actions.create')
            @endslot
            <thead>
                <tr>
                    {{-- <th>@lang('services::services.attributes.image')</th> --}}
                    <th>@lang('services::services.attributes.name')</th>
                    <th>...</th>
                </tr>
            </thead>

            <tbody>
                @forelse($services as $service)
                    <tr>
                        {{-- <td class="d-none d-md-table-cell">
                            <img src="{{ $service->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                        </td> --}}
                        <td>
                            {{ $service->name }}
                        </td>
                        <td>
                            @include('services::services.partials.actions.show')
                            @include('services::services.partials.actions.edit')
                            @include('services::services.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('services::services.empty')</td>
                    </tr>
                @endforelse

                @if ($services->hasPages())
                    @slot('footer')
                        {{ $services->links() }}
                    @endslot
                @endif
            </tbody>
        @endcomponent
    @endcomponent
@endsection
