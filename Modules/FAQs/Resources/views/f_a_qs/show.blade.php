@extends('dashboard::layouts.default')

@section('title')
    {{ $f_a_q->id }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $f_a_q->id)
        @slot('breadcrumbs', ['dashboard.f_a_qs.show', $f_a_q])

        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('f_a_qs::f_a_qs.attributes.question')</th>
                                <td>{{ $f_a_q->question }}</td>
                                {{-- <td>
                                    @include('dashboard::layouts.apps.list', [
                                        'model' => $f_a_q,
                                        'target' => 'question',
                                    ])
                                </td> --}}
                            </tr>
                            <tr>
                                <th width="200">@lang('f_a_qs::f_a_qs.attributes.answer')</th>
                                <td>{{ $f_a_q->answer }}</td>
                                {{-- <td>
                                    @include('dashboard::layouts.apps.list', [
                                        'model' => $f_a_q,
                                        'target' => 'answer',
                                        'type' => 'editor',
                                    ])
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('f_a_qs::f_a_qs.partials.actions.edit')
                        @include('f_a_qs::f_a_qs.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
