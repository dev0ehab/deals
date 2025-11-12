@component('dashboard::layouts.components.page-form')
    @slot('title', '')
    {{ BsForm::post(route('dashboard.sub_features.store', $feature), ['files' => true, 'data-parsley-validate']) }}
    @component('dashboard::layouts.components.box')
        @slot('title', trans('features::sub_features.actions.create'))

        @include('features::sub_features.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('features::sub_features.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
@endcomponent
