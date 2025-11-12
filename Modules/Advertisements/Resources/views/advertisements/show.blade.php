@extends('dashboard::layouts.default')

@section('title')
    {{ $advertisement->title }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $advertisement->title)
        @slot('breadcrumbs', ['dashboard.advertisements.show', $advertisement])

        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.title')</th>
                                <td>{{ $advertisement->title }}</td>
                            </tr>
                            <tr>
                                <th>@lang('advertisements::advertisements.attributes.url')</th>
                                <td>{{ $advertisement->url }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.image')</th>
                                <td>
                                    <img src="{{ $advertisement->getFirstMediaUrl('images') }}" class="mr-2 img-thumbnail"
                                        style="width: 140px; height: 110px;">
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('advertisements::advertisements.attributes.active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $advertisement->active,
                                    ])
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('advertisements::advertisements.partials.actions.edit')
                        @include('advertisements::advertisements.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent

    {{-- @include('advertisements::subadvertisements.index') --}}
@endsection
