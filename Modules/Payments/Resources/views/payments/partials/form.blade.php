@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@bsMultilangualFormTabs
    {{ BsForm::text('name') }}
@endBsMultilangualFormTabs


<div class="col-4">
    <div class="custom-control custom-switch my-4" dir="ltr">
        <input type="hidden" name="active" value="0">
        @isset($payment)
            <input type="checkbox" name="active" value="1" class="custom-control-input" id="active"
                {{ $payment->active ? 'checked' : '' }}>
        @else
            <input type="checkbox" name="active" value="1" class="custom-control-input" id="active">
        @endisset
        <label class="custom-control-label"
            for="active">{{ __('payments::payments.attributes.active') }}</label>
    </div>
</div>

{{-- {{ BsForm::checkbox('active')->value(1)->checked($payment->active ?? old('active')) }} --}}

{{-- @isset($payment)
    {{ BsForm::media('media')->collection('icon')->accept('image/*')->files($payment->getMediaResource('icon'))->notes(trans('payments::payments.messages.images_note')) }}
@else
    {{ BsForm::media('media')->collection('icon')->accept('image/*')->notes(trans('payments::payments.messages.images_note')) }}
@endisset --}}

<div class="row">
    <div class="col-12">
        <label>{{ __('payments::payments.attributes.image') }}</label>
        @isset($payment)
            @include('dashboard::layouts.apps.file', [
                'file' => $payment->getImage(),
                'name' => 'media',
                'mimes' => 'png jpg jpeg'
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'media'])
        @endisset
    </div>
</div>


