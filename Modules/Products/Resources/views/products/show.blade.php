@extends('dashboard::layouts.default')

@section('title')
    {{ $product->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $product->name)
        @slot('breadcrumbs', ['dashboard.products.show', $product])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('products::products.attributes.name')</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('sections::sections.singular')</th>
                                <td>{{ $product->section->name }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.cover')</th>
                                <td>
                                    <img src="{{ $product->cover }}" width="150" class="rounded" alt="{{ $product->name }}">
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.image')</th>
                                <td>
                                    @foreach($product->images as $image)
                                    <img src="{{ $image['url'] }}" width="150" class="rounded" alt="{{ $product->name }}">
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.price')</th>
                                <td>{{ $product->price }}</td>
                            </tr>
                            @if($product->old_price)
                            <tr>
                                <th width="200">@lang('products::products.attributes.old_price')</th>
                                <td>{{ $product->old_price }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th width="200">@lang('products::products.attributes.stock')</th>
                                <td>{{ $product->stock }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.is_active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $product->is_active,
                                        ])
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('products::products.partials.actions.edit')
                        @include('products::products.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                @component('dashboard::layouts.components.table-box')
                    @slot('title', trans('products::products.features.plural', [], app()->getLocale()) ?? 'Product Features')
                    @slot('tools')
                        @include('products::products.partials.actions.add-feature')
                    @endslot

                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>@lang('products::products.features.feature', [], app()->getLocale())</th>
                            <th width="150">@lang('products::products.features.type', [], app()->getLocale())</th>
                            <th>@lang('products::products.features.value', [], app()->getLocale())</th>
                            <th width="180">@lang('products::products.attributes.is_active')</th>
                            <th style="width: 160px">...</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->features as $feature)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($feature->feature)->name ?? '-' }}
                                </td>
                                <td>
                                    {{ ucfirst($feature->feature_type ?? '-') }}
                                </td>
                                <td>
                                    @if($feature->feature_type === 'text')
                                        {{ app()->getLocale() === 'ar' ? ($feature->text_value_ar ?? $feature->text_ar ?? '-') : ($feature->text_value_en ?? $feature->text_en ?? '-') }}
                                    @elseif($feature->feature_type === 'image')
                                        @if($feature->image)
                                            <img src="{{ $feature->image }}" alt="feature" class="mr-2 rounded" width="64" height="64">
                                        @else
                                            -
                                        @endif
                                    @elseif($feature->feature_type === 'data')
                                        @php $opts = $feature->featureOptions; @endphp
                                        @if($opts && $opts->count())
                                            <ul class="mb-0 pl-3">
                                                @foreach($opts as $opt)
                                                    <li>{{ $opt->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $feature->is_active ?? false,
                                    ])
                                </td>
                                <td style="width: 180px">
                                    @include('products::features.partials.actions.edit')
                                    @include('products::features.partials.actions.delete')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="text-center">@lang('products::products.features.empty', [], app()->getLocale())</td>
                            </tr>
                        @endforelse
                    </tbody>
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
