<div class="row">
    <div class="col-12">
        <label>{{ __('services::services.attributes.images') }}</label>
        @if (isset($service))
            @include('dashboard::layouts.apps.multi', [
                'name' => 'images[]',
                'images' => $service->images,
                'mimes' => 'png jpg jpeg',
            ])
        @else
            @include('dashboard::layouts.apps.multi', [
                'name' => 'images[]',
                'mimes' => 'png jpg jpeg',
            ])
        @endif
    </div>
</div>
