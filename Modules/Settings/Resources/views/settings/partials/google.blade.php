@component(layout('dashboard').'components.accordion')

    @slot('title', trans('settings::settings.actions.google_settings'))

    {{ BsForm::text('google_analytics')->value((new Modules\Settings\Entities\Setting)->get('google_analytics', null)) }}
    {{ BsForm::text('tag_manager')->value((new Modules\Settings\Entities\Setting)->get('tag_manager', null))->note(trans('settings::settings.messages.tag_manager_note')) }}


@endcomponent
