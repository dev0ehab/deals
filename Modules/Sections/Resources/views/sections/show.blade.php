@extends('dashboard::layouts.default')

@section('title')
    {{ $section->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $section->name)
        @slot('breadcrumbs', ['dashboard.sections.show', $section])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('sections::sections.attributes.image')</th>
                                <td>
                                    <img src="{{ $section->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                                </td>
                            </tr>
                            <tr></tr>
                                <th width="200">@lang('sections::sections.attributes.name')</th>
                                <td>
                                    {{ $section->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('sections::sections.partials.actions.edit')
                        @include('sections::sections.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
