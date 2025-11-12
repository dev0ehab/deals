@extends('dashboard::layouts.default')

@section('title')
    {{ $service->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $service->name)
        @slot('breadcrumbs', ['dashboard.services.show', $service])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('services::services.attributes.name')</th>
                                <td>{{ $service->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('services::services.attributes.image')</th>
                                <td>
                                    <img src="{{ $service->getImage() }}" class="mr-2 img-thumbnail" width="150px">
                                </td>
                            </tr>


                        </tbody>
                    </table>

                    @slot('footer')
                        @include('services::services.partials.actions.edit')
                        @include('services::services.partials.actions.delete')
                    @endslot
                @endcomponent

            </div>
        </div>
    @endcomponent
@endsection
