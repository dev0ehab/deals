<?php

Breadcrumbs::for('dashboard.contactus.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('settings::contactus.plural'), route('dashboard.contact-us.index'));
});

Breadcrumbs::for('dashboard.contactus.show', function ($breadcrumb, $contact) {
    $breadcrumb->parent('dashboard.contactus.index');
    $breadcrumb->push($contact->name, route('dashboard.contact-us.show', $contact));
});
