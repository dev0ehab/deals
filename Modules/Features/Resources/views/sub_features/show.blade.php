@extends('dashboard::layouts.default')

@section('title')
    {{ $sub_feature->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $sub_feature->name)
        @slot('breadcrumbs', ['dashboard.sub_features.show', $sub_feature])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('features::features.attributes.name')</th>
                                <td>{{ $sub_feature->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('features::features.attributes.image')</th>
                                <td>
                                    <img src="{{ $sub_feature->getImage() }}" class="mr-2 img-thumbnail" width="150px">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('features::features.partials.actions.edit', ['feature' => $sub_feature])
                        @include('features::features.partials.actions.delete', ['feature' => $sub_feature])
                    @endslot
                @endcomponent

                @include('features::sub_features.create', ['feature' => $sub_feature])
            </div>
            <div class="col-md-6">
                @if (count($sub_features) > 0)
                    @include('features::sub_features.index', ['feature' => $sub_feature])
                @endif
            </div>
        </div>
    @endcomponent
@endsection
