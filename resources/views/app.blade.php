<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title inertia>{{ config('app.name', 'Laravue Dashboard') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="/hexadash/img/favicon.png">

    {{-- Fonts. Unicons (uil-*) is self-hosted via Vite — see resources/js/app.js. --}}
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Hexadash theme styles. jQuery/Bootstrap JS intentionally dropped — interactivity is rebuilt in Vue. --}}
    <link rel="stylesheet" href="/hexadash/assets/vendor_assets/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/hexadash/assets/vendor_assets/css/fontawesome.css">
    <link rel="stylesheet" href="/hexadash/assets/vendor_assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="/hexadash/style.css">

    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

{{-- `loaded` hides the theme's JS-driven page-loader overlay (body:after); we don't ship that loader. --}}
<body class="layout-light side-menu loaded">
@inertia
</body>

</html>
