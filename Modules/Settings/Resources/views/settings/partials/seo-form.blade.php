@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading3">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    # {{ __('Google analytics and Facebook pixel') }}
                </button>
            </h2>
        </div>

        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.facebook_pixel')</label>
                            <textarea type="text" name="facebook_pixel" class="form-control" rows="3"> {{ Settings::get('facebook_pixel') }} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.google_id_header')</label>
                            <textarea type="text" name="google_id_head" class="form-control" rows="3"> {{ Settings::get('google_id_head') }} </textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.google_id_footer')</label>
                            <textarea type="text" name="google_id_footer" class="form-control" rows="3"> {{ Settings::get('google_id_footer') }} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.track_code')</label>
                            <textarea type="text" name="track_code" class="form-control" rows="3"> {{ Settings::get('track_code') }} </textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.google_analects')</label>
                            <textarea type="text" name="google_analects" class="form-control" rows="3"> {{ Settings::get('google_analects') }} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.btn_track_code')</label>
                            <textarea type="text" name="btn_track_code" class="form-control" rows="3"> {{ Settings::get('btn_track_code') }} </textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.btn_google_id_footer')</label>
                            <textarea type="text" name="btn_google_id_footer" class="form-control" rows="3"> {{ Settings::get('btn_google_id_footer') }} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">@lang('settings::settings.attributes.transfer_line')</label>
                            <textarea type="text" name="transfer_line" class="form-control" rows="3"> {{ Settings::get('transfer_line') }} </textarea>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading4">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                    # {{ __('Home Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('home_seo_title')->value(Settings::get('home_seo_title'))->label(__('Home SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('home_seo_keywords')->value(Settings::get('home_seo_keywords'))->label(__('Home SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('home_seo_description')->value(Settings::get('home_seo_description'))->rows(3)->label(__('Home SEO Description')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading7">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                    # {{ __('About Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('about_seo_title')->value(Settings::get('about_seo_title'))->label(__('About SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('about_seo_keywords')->value(Settings::get('about_seo_keywords'))->label(__('About SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('about_seo_description')->value(Settings::get('about_seo_description'))->rows(3)->label(__('About SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading8">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
                    # {{ __('Services Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('services_seo_title')->value(Settings::get('services_seo_title'))->label(__('Services SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('services_seo_keywords')->value(Settings::get('services_seo_keywords'))->label(__('Services SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('services_seo_description')->value(Settings::get('services_seo_description'))->rows(3)->label(__('Services SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading10">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
                    # {{ __('Media Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('media_seo_title')->value(Settings::get('media_seo_title'))->label(__('Media SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('media_seo_keywords')->value(Settings::get('media_seo_keywords'))->label(__('Media SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('media_seo_description')->value(Settings::get('media_seo_description'))->rows(3)->label(__('Media SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading9">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">
                    # {{ __('Reports Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('reports_seo_title')->value(Settings::get('reports_seo_title'))->label(__('Reports SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('reports_seo_keywords')->value(Settings::get('reports_seo_keywords'))->label(__('Reports SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('reports_seo_description')->value(Settings::get('reports_seo_description'))->rows(3)->label(__('Reports SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading6">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                    # {{ __('Volunteers Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('volunteers_seo_title')->value(Settings::get('volunteers_seo_title'))->label(__('Volunteers SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('volunteers_seo_keywords')->value(Settings::get('volunteers_seo_keywords'))->label(__('Volunteers SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('volunteers_seo_description')->value(Settings::get('volunteers_seo_description'))->rows(3)->label(__('Volunteers SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading11">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                    # {{ __('Donations Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('donations_seo_title')->value(Settings::get('donations_seo_title'))->label(__('Donations SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('donations_seo_keywords')->value(Settings::get('donations_seo_keywords'))->label(__('Donations SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('contact_seo_description')->value(Settings::get('contact_seo_description'))->rows(3)->label(__('Donations SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading5">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                    # {{ __('Contact Page') }}
                </button>
            </h2>
        </div>

        <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        {{ BsForm::text('contact_seo_title')->value(Settings::get('contact_seo_title'))->label(__('Contact Us SEO Title')) }}
                    </div>
                    <div class="col-6">
                        {{ BsForm::text('contact_seo_keywords')->value(Settings::get('contact_seo_keywords'))->label(__('Contact Us SEO Keywords')) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('contact_seo_description')->value(Settings::get('contact_seo_description'))->rows(3)->label(__('Contact Us SEO Description')) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- last 11 --}}

</div>
