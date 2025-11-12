@extends('dashboard::layouts.default')

@section('title')
    {{ $role->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $role->name)
        @slot('breadcrumbs', ['dashboard.roles.show', $role])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                        <tr>
                            <th width="200">@lang('roles::roles.attributes.name')</th>
                            <td>{{ $role->name }}</td>
                        </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('roles::roles.partials.actions.edit')
                        @include('roles::roles.partials.actions.delete')
                    @endslot
                @endcomponent

            </div>
        </div>

    @endcomponent
@endsection
