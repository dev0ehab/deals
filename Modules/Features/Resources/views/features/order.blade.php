@extends('dashboard::layouts.default')

@section('title')
    @lang('features::features.actions.order')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('features::features.actions.order'))
        @slot('breadcrumbs', ['dashboard.features.order'])

        {{ BsForm::resource('features::features')->post(route('dashboard.order.features')) }}
        @component('dashboard::layouts.components.box')
            @slot('title')
                <i class="fas fa-sort-amount-up-alt"></i>
                {{ __('Drag And Drop To Reoder The features') }}
            @endslot

            <table class="grid table table-striped- table-bordered table-hover table-checkable text-center" id="sortFixed">
                <tbody>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('features::features.attributes.name') }}</th>
                            <th>{{ __('features::features.attributes.image') }}</th>
                        </tr>
                    </thead>
                    @foreach ($features as $item)
                        <tr style="cursor: pointer;">
                            <input type="hidden" name='features[]' value="{{ $item->id }}" class="form-controldrag">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <img src="{{ $item->getImage() }}" alt="Product 1" class="img-circle img-size-32 mr-2"
                                    style="height: 32px;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @slot('footer')
                {{ BsForm::submit()->label(trans('order')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

@push('js')
    @include('dashboard::layouts.apps.rank')
@endpush
