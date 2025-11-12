<!-- App css -->
@if (Locales::getDir() === 'rtl')
    <link href="{{ asset(mix('css/backend.rtl.css')) }}" id="app-light" rel="stylesheet" type="text/css" />
    <style>
        .notification-drop.show {
            width: 320px !important;
        }

        .notification-drop.dropdown-menu-right {
            right: -275px !important;
            left: auto !important;
        }
    </style>

    {{-- <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" /> --}}
@else
    <link href="{{ asset(mix('css/backend.css')) }}" id="app-light" rel="stylesheet" type="text/css" />
    {{-- <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" /> --}}
    <style>
        .notification-drop.show {
            width: 320px !important;
        }

        .notification-drop.dropdown-menu-right {
            left: -275px !important;
        }
    </style>
@endif

<style>
    td {
        vertical-align: middle !important;
    }

</style>

@stack('css')
