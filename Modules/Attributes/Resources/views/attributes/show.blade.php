@extends('dashboard::layouts.default')

@section('title')
    {{ $attribute->title }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $attribute->title)
        @slot('breadcrumbs', ['dashboard.attributes.show', $attribute])

        <div class="row">

            {{-- IF is not in pricing matrix show warning --}}
            @if (!$attribute->isInPriceMatrix())
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        @lang('attributes::attributes.attributes.warning_pricing_matrix')
                    </div>
                </div>
            @endif

            {{-- IF its options is in pricing matrix show pricing matrix --}}
            @foreach($attribute->options as $option)
                @if(!$option->isInPriceMatrix())
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            @lang('attributes::attributeOptions.attributes.pricing_matrix_active')
                        </div>
                    </div>
                    @break
                @endif
            @endforeach


            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('attributes::attributes.attributes.title')</th>
                                <td>{{ $attribute->title }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('attributes::attributes.attributes.description')</th>
                                <td>{!! $attribute->description !!}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('attributes::attributes.attributes.type')</th>
                                <td>{{ trans('attributes::attributes.types.' . $attribute->type) }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('attributes::attributes.attributes.pricing_type')</th>
                                <td>{{ \App\Enums\AttributePricingEnum::translatedName($attribute->pricing_type) }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('attributes::attributes.attributes.is_active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $attribute->is_active,
                                    ])
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('attributes::attributes.partials.actions.edit')
                        @include('attributes::attributes.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>

            <div class="col-md-6">
                @if (count($attribute->options) > 0)
                    @component('dashboard::layouts.components.accordion-table')
                        @slot('bodyClass', 'p-0')
                        @slot('title', trans('attributes::attributeOptions.plural'))
                        <tr>
                            <th width="100">#</th>
                            <th>@lang('attributes::attributeOptions.attributes.name')</th>
                            <th>@lang('attributes::attributeOptions.attributes.image')</th>
                            <th>@lang('attributes::attributeOptions.attributes.icon')</th>

                            @if ($attribute->pricing_type === 'total_price' || $attribute->pricing_type === 'paper_price')
                                <td>{{ \App\Enums\AttributePricingEnum::translatedName($attribute->pricing_type) }}</td>
                            @endif

                            <th>@lang('attributes::attributeOptions.attributes.is_default')</th>

                        </tr>
                        @foreach ($attribute->options as $option)
                            <tr @if(!$option->isInPriceMatrix()) class="bg-warning" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $option->name }}</td>

                                <td>
                                    @if ($option->image_url)
                                        <img src="{{ $option->image_url }}" alt="{{ $option->name }}" class="img-fluid"
                                            style="width: 100px; height: 100px;">
                                    @else
                                        <span class="text-muted">@lang('attributes::attributeOptions.attributes.no_image')</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($option->icon_url)
                                        <img src="{{ $option->icon_url }}" alt="{{ $option->name }}" class="img-fluid"
                                            style="width: 100px; height: 100px;">
                                    @else
                                        <span class="text-muted">@lang('attributes::attributeOptions.attributes.no_icon')</span>
                                    @endif
                                </td>

                                @if ($attribute->pricing_type === 'paper_price')
                                    <td>
                                        {{ $option->paper_count_factor }}
                                    </td>
                                @endif

                                @if ($attribute->pricing_type === 'total_price')
                                    <td>
                                        {{ $option->price }}
                                    </td>
                                @endif

                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $option->is_default,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    @endcomponent
                @endif

            </div>

        </div>
    @endcomponent
@endsection


@push('css')
    <style>
        .table-middle td {
            vertical-align: middle !important;
        }
    </style>
@endpush
