@extends('dashboard::layouts.default')

@section('title')
    {{ $notification->title }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $notification->title)
        @slot('breadcrumbs', ['dashboard.notifications.show', $notification])

        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('notifications::notifications.attributes.title')</th>
                            <td>{{ $notification->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('notifications::notifications.attributes.description')</th>
                            <td>{!! $notification->description !!}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('notifications::notifications.attributes.image')</th>
                            <td>
                                <img src="{{ $notification->getImage() }}"
                                     class="img img-size-"
                                     alt="{{ $notification->title }}" width="300px">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('notifications::notifications.partials.actions.edit')
                        @include('notifications::notifications.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection
