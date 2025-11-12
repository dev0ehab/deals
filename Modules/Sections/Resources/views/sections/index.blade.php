@extends('dashboard::layouts.default')

@section('title')
    @lang('sections::sections.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('sections::sections.plural'))
        @slot('breadcrumbs', ['dashboard.sections.index'])

        @include('sections::sections.partials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('sections::sections.actions.list'))
            @slot('tools')
                @include('sections::sections.partials.actions.create')
            @endslot

            <thead>
                <tr>
                    <th>@lang('sections::sections.attributes.image')</th>
                    <th>@lang('sections::sections.attributes.name')</th>
                    <th style="width: 160px">...</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sections as $section)
                    <tr>
                        <td>
                            <img src="{{ $section->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                        </td>

                        <td>
                            {{ $section->name }}
                        </td>

                        <td style="width: 160px">
                            @include('sections::sections.partials.actions.show')
                            @include('sections::sections.partials.actions.edit')
                            @include('sections::sections.partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('sections::sections.empty')</td>
                    </tr>
                @endforelse

                @if ($sections->hasPages())
                    @slot('footer')
                        {{ $sections->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent
    @endsection
