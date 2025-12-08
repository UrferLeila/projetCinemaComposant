<!doctype html>
<html lang="fr">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, 
        shrink-to-fit=no" />
    @vite('resources/js/appvue.js')
    @vite('resources/css/styles.css')
</head>

<body>
    @include('partials/header')
    <main>
        <div id="app"></div>
        @yield('content')
    </main>
</body>

</html>