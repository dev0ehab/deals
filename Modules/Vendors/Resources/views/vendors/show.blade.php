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
                        <th>@lang('vendors::vendors.attributes.name')</th>
                        <td>{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.phone')</th>
                        <td>{{ $vendor->phone }}</td>
                    </tr>
                    <tr>
                        <th>@lang('companies::companies.singular')</th>
                        <td>{{ $vendor->company->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('vendors::vendors.attributes.avatar')</th>
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
                @include('vendors::vendors.partials.actions.edit')
                @include('vendors::vendors.partials.actions.delete')
                @include('vendors::vendors.partials.actions.block')
            @endslot
        @endcomponent
    @endcomponent
@endsection
