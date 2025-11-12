@extends('dashboard::layouts.default')

@section('title')
    {{ $feature->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $feature->name)
        @slot('breadcrumbs', ['dashboard.features.show', $feature])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')


                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('features::features.attributes.name')</th>
                                <td>{{ $feature->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('features::features.attributes.description')</th>
                                <td>{!! $feature->description !!}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('features::features.attributes.image')</th>
                                <td>
                                    <img src="{{ $feature->image }}" class="img img-size-" width="200"
                                        alt="{{ $feature->name }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('features::features.partials.actions.edit')
                        @include('features::features.partials.actions.delete')
                    @endslot
                @endcomponent


            </div>


            <div class="col-md-6">
                <div>
                        @component('dashboard::layouts.components.accordion-table')
                            @slot('bodyClass', 'p-0')
                            @slot('title', trans('features::options.plural'))

                            <tr>
                                <th>@lang('features::options.attributes.image')</th>
                                <th>@lang('features::options.attributes.name')</th>
                                <th>...</th>
                            </tr>

                            @forelse($options as $option)
                                <tr>
                                    <td class="d-none d-md-table-cell">
                                        <img src="{{ $option->image }}" class="img-size-32 mr-2"
                                            style="height: 32px;">
                                    </td>
                                    <td>
                                        {{ $option->name }}
                                    </td>
                                    <td>
                                        @include('features::options.partials.actions.show')
                                        @include('features::options.partials.actions.edit')
                                        @include('features::options.partials.actions.delete')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100" class="text-center">@lang('features::options.empty')</td>
                                </tr>
                            @endforelse
                        @endcomponent
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                @include('features::options.create')
            </div>
        </div>
    @endcomponent
@endsection
