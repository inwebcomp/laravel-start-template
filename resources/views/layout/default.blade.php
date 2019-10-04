<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" href="/img/favicon.png" type="image/png">

    @include('layout.meta')

    @yield('styles')
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        @yield('content')

        <transition name="fade">
            <div class="popup-mask" v-show="popupIsActive" @click="$root.$emit('closePopup')"></div>
        </transition>
    </div>

    @yield('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
