@extends('dashboard::layouts.default')

@section('title')
    {{ $coupon->code }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $coupon->code)
        @slot('breadcrumbs', ['dashboard.coupons.show', $coupon])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.code')</th>
                                <td>{{ $coupon->code }}</td>
                            </tr>
                            @if($coupon->description)
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.description')</th>
                                <td>{!! $coupon->description !!}</td>
                            </tr>
                            @endif
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.discount_type')</th>
                                <td>
                                    <span class="badge badge-info">
                                        {{ __('coupons::coupons.options.discount_type.' . $coupon->discount_type) }}
                                    </span>
                                </td>
                            </tr>

                            @if($coupon->discount_type !== 'delivery')
                            <tr>
                                <th width="200">Coupon Type</th>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ ucfirst($coupon->coupon_type ?? 'percent') }}
                                    </span>
                                </td>
                            </tr>
                            @endif



                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.max_usage')</th>
                                <td>{{ $coupon->max_usage }}</td>
                            </tr>

                            
                            @if($coupon->discount_type !== 'delivery')
                                @if(($coupon->coupon_type ?? 'percent') === 'percent')
                                <tr>
                                    <th width="200">@lang('coupons::coupons.attributes.percentage_discount')</th>
                                    <td>{{ $coupon->percentage_discount }} %</td>
                                </tr>
                                @endif
                                <tr>
                                    <th width="200">@lang('coupons::coupons.attributes.max_discount')</th>
                                    <td>{{ $coupon->max_discount }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.is_active')</th>
                                <td>@include('coupons::coupons.partials.is_active')</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.max_usage_per_user')</th>
                                <td>{{ $coupon->max_usage_per_user }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.first_order_count')</th>
                                <td>{{ $coupon->first_order_count ?? 'Unlimited' }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.start_at')</th>
                                <td>{{ $coupon->start_at->toDateString() }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.expire_at')</th>
                                <td>{{ $coupon->expire_at->toDateString() }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('coupons::coupons.attributes.duration')</th>
                                <td>{{ $coupon->duration }} @lang('coupons::coupons.attributes.day')
                                    ( @lang('coupons::coupons.attributes.remaining_duration') {{ $coupon->remaining_duration }} @lang('coupons::coupons.attributes.day'))
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('coupons::coupons.partials.actions.edit')
                        @include('coupons::coupons.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
