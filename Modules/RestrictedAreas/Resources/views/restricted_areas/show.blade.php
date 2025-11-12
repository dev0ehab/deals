@extends('dashboard::layouts.default')

@section('title')
    {{ $restricted_area->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $restricted_area->name)
        @slot('breadcrumbs', ['dashboard.restricted_areas.show', $restricted_area])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('restricted_areas::restricted_areas.attributes.name')</th>
                                <td>
                                    {{ $restricted_area->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('restricted_areas::restricted_areas.partials.actions.edit')
                        @include('restricted_areas::restricted_areas.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
