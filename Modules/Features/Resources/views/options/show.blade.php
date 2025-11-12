@extends('dashboard::layouts.default')

@section('title')
    {{ $option->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $option->name)
        @slot('breadcrumbs', ['dashboard.options.show', $option])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('features::options.attributes.name')</th>
                                <td>{{ $option->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('features::options.attributes.image')</th>
                                <td>
                                    <img src="{{ $option->getImage() }}" class="mr-2 img-thumbnail" width="150px">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('features::options.partials.actions.edit')
                        @include('features::options.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
