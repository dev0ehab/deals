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
        <div class="card-header" id="heading1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    # {{ __('Subscribe Mail Template') }}
                </button>
            </h2>
        </div>

        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::text('subscribe_mail_subject')->value(Settings::get('subscribe_mail_subject'))->label(__('Subject')) }}
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('subscribe_mail_message')->rows(3)->attribute('class', 'form-control ckeditor')->attribute('id', 'mailEditor1')->value(Settings::get('subscribe_mail_message'))->label(__('Message')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading2">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                    # {{ __('Contacts Mail Template') }}
                </button>
            </h2>
        </div>

        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::text('contact_mail_subject')->value(Settings::get('contact_mail_subject'))->label(__('Subject')) }}
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('contact_mail_message')->rows(3)->attribute('class', 'form-control ckeditor')->attribute('id', 'mailEditor2')->value(Settings::get('contact_mail_message'))->label(__('Message')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="heading3">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    # {{ __('Donors Mail Template') }}
                </button>
            </h2>
        </div>

        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::text('donation_mail_subject')->value(Settings::get('donation_mail_subject'))->label(__('Subject')) }}
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('donation_mail_message')->rows(3)->attribute('class', 'form-control ckeditor')->attribute('id', 'mailEditor3')->value(Settings::get('donation_mail_message'))->label(__('Message')) }}
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
                    # {{ __('Volunteers Mail Template') }}
                </button>
            </h2>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        {{ BsForm::text('volunteer_mail_subject')->value(Settings::get('volunteer_mail_subject'))->label(__('Subject')) }}
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        {{ BsForm::textarea('volunteer_mail_message')->rows(3)->attribute('class', 'form-control ckeditor')->attribute('id', 'mailEditor4')->value(Settings::get('volunteer_mail_message'))->label(__('Message')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@push('js')
<script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('mailEditor1', {
        filebrowserUploadUrl: "{{route('image.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('mailEditor2', {
        filebrowserUploadUrl: "{{route('image.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('mailEditor3', {
        filebrowserUploadUrl: "{{route('image.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('mailEditor4', {
        filebrowserUploadUrl: "{{route('image.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endpush
