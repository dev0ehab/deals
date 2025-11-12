<hr>

<h5> # {{ __("Seo Data") }} </h5>

{{ BsForm::text('meta_title')->value(isset($item) ? $item->seo()->meta_title : null)->label(__("Meta Title")) }}
{{ BsForm::textarea('meta_description')->rows(3)->value(isset($item) ? $item->seo()->meta_description : null)->label(__("Meta Description")) }}
{{ BsForm::text('meta_keywords')->value(isset($item) ? $item->seo()->meta_keywords : null)->label(__("Meta Keywords")) }}

