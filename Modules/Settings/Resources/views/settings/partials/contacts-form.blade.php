@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- {{ BsForm::text('phone')->value(Settings::get('phone')) }} --}}
{{ BsForm::text('whats_app')->value(Settings::get('whats_app')) }}
{{ BsForm::text('email')->value(Settings::get('email')) }}
{{-- BsForm::text('mobile')->value(Settings::get('mobile')) }}
{{ BsForm::text('fax')->value(Settings::get('fax')) }} --}}


<label> @lang('settings::settings.attributes.phone') </label>
<div data-repeater-list="phones">
    @if (Settings::get('phones') != null)
        @foreach (Settings::get('phones') as $phone)
            <div data-repeater-item>
                <div class="row my-2">
                    <div class="col-11">
                        <div class="form-group">
                            <input type="tel" name="phone" required class="form-control" value="{{ $phone }}">
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="button" data-repeater-delete class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div data-repeater-item>
            <div class="row my-2">
                <div class="col-11">
                    <div class="form-group">
                        <input type="tel" name="phone" required class="form-control" placeholder="{{ __('phone') }}">
                    </div>
                </div>
                <div class="col-1">
                    <button type="button" data-repeater-delete class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
<button type="button" data-repeater-create class="btn btn-primary my-2">
    <i class="fa fa-plus"></i>
</button>
