@include('dashboard::errors')

@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::text('title')->required() }}
    {{ BsForm::textarea('description')->attribute('class', 'form-control textarea')->rows('3') }}
@endBsMultilangualFormTabs

{{ BsForm::number('price')->min('.01')->step('.01')->required() }}


<div class="row">
    <div class="col-12">
        <label>{{ __('services::services.attributes.cover') }}</label>
        @isset($service)
            @include('dashboard::layouts.apps.file', [
                'file' => $service->cover,
                'name' => 'cover',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'cover'])
        @endisset
    </div>
</div>


@php
    use App\Enums\ServicesEnum;
    $serviceName = ServicesEnum::serviceName($service->id);
@endphp

@includeIf("services::services.partials.home_pages.{$serviceName}")
