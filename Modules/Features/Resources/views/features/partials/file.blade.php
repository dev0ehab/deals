@isset($feature)
    {{ BsForm::image('image')->collection('images')->files($feature->getMediaResource('images'))->notes(trans('features::features.attributes.image')) }}
@else
    {{ BsForm::image('image')->collection('images')->notes(trans('features::features.attributes.image')) }}
@endisset
