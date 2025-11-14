@extends('dashboard::layouts.default')

@section('title')
    {{ $vendor->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $vendor->name)
        @slot('breadcrumbs', ['dashboard.vendors.show', $vendor])

        @component('dashboard::layouts.components.box')
            @slot('bodyClass', 'p-0')

            <table class="table table-middle">
                <tbody>
                    <tr>
                        <th>@lang('vendors::vendorsattributes.name')</th>
                        <td>{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendorsattributes.phone')</th>
                        <td>{{ $vendor->phone }}</td>
                    </tr>
                    <tr>
                        <th>@lang('companies::companies.singular')</th>
                        <td>{{ $vendor->company->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendorsattributes.avatar')</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-70 symbol-sm flex-shrink-0">
                                    <img class="" src="{{ $vendor->getAvatar() }}" alt="{{ $vendor->name }}" width="150">
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            @slot('footer')
                @include('vendors::vendorspartials.actions.edit')
                @include('vendors::vendorspartials.actions.delete')
                @include('vendors::vendorspartials.actions.block')
            @endslot
        @endcomponent
    @endcomponent
@endsection
