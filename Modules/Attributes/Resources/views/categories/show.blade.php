@extends('dashboard::layouts.default')

@section('title')
    {{ $category->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $category->name)
        @slot('breadcrumbs', ['dashboard.categories.show', $category])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('attributes::categories.attributes.name')</th>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('attributes::categories.attributes.is_active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $category->is_active,
                                    ])
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('attributes::categories.attributes.icon')</th>
                                <td>
                                    <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="img-fluid">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('attributes::categories.partials.actions.edit')
                        @include('attributes::categories.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>


        </div>
    @endcomponent
@endsection
