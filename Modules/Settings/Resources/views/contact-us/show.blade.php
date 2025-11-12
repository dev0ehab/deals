@extends('dashboard::layouts.default')

@section('title')
    {{ $contact->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $contact->name)
        @slot('breadcrumbs', ['dashboard.contactus.show', $contact])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('settings::contactus.attributes.name')</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('settings::contactus.attributes.email')</th>
                            <td>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th width="200">@lang('settings::contactus.attributes.message')</th>
                            <td>{{ $contact->message }}</td>
                        </tr>

                        </tbody>
                    </table>

                    @slot('footer')
                        @include('settings::contact-us.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection
