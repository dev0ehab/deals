@component('dashboard::layouts.components.page-form')
    @slot('title', '')
    {{ BsForm::post(route('dashboard.options.store', $feature), ['files' => true, 'data-parsley-validate']) }}
    @component('dashboard::layouts.components.box')
        @slot('title', trans('features::options.actions.create'))

        @include('features::options.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('features::options.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
@endcomponent
