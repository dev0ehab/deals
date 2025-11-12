@extends('dashboard::layouts.default')

@section('title')
    @lang('dashboard::dashboard.home')
@endsection

{{-- Content --}}
@section('content')
    {{-- Dashboard 1 --}}

    @component('dashboard::layouts.components.page')
        @slot('title', trans('dashboard::dashboard.home'))

        @slot('breadcrumbs', ['dashboard.home'])

        <div class="row">
            <div class="col-lg-12">
                <div class="card no-card-border gutter-b">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h3 class="m-b-0">@lang('dashboard::dashboard.welcome')</h3>
                                @php
                                    \Date::setLocale(app()->getLocale());
                                    $of = trans('dashboard::dashboard.of');
                                    $date = \Date::now()->format('l jS ' . $of . ' F Y');
                                @endphp
                                <span>{{ $date }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @include('dashboard::layouts.apps.statestics')

                @if (!auth()->user()->isVendor())
                    <div class="row">
                        <div class="col-lg-6">
                            @include('dashboard::layouts.apps.inbox')
                        </div>

                        <div class="col-lg-6">
                            @include('dashboard::layouts.apps.notifications')
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endcomponent
@endsection
