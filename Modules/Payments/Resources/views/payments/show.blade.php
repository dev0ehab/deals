@extends('dashboard::layouts.default')

@section('title')
    {{ $payment->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $payment->name)
        @slot('breadcrumbs', ['dashboard.payments.show', $payment])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('payments::payments.attributes.name')</th>
                            <td>{{ $payment->name }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('payments::payments.attributes.active')</th>
                            <td>@include('payments::payments.partials.flags.active')</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('payments::payments.attributes.created_at')</th>
                            <td>{{  $payment->created_at->toDateString() }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('payments::payments.attributes.image')</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-70 symbol-sm flex-shrink-0">
                                        <img width="100" src="{{ $payment->getImage() }}" alt="{{ $payment->name }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('payments::payments.partials.actions.edit')
                        {{-- @include('payments::payments.partials.actions.delete') --}}
                    @endslot
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection
