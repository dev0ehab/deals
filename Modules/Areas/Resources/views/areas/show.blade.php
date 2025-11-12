@extends('dashboard::layouts.default')

@section('title')
    {{ $area->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $area->name)
        @slot('breadcrumbs', ['dashboard.areas.show', $area])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('areas::areas.attributes.name')</th>
                                <td>
                                    {{ $area->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('areas::areas.partials.actions.edit')
                        @include('areas::areas.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
