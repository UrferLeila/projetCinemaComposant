<!doctype html>
<html lang="fr">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @vite('resources/js/appvue.js')
    @vite('resources/css/styles.css')
</head>

<body>
    @include('partials/header')

    <main>
        <div id="app"></div>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Profile dropdown script -->
    <script>
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        profileBtn?.addEventListener('click', () => {
            profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', (e) => {
            if (!profileBtn?.contains(e.target) && !profileMenu?.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
        });
    </script>
</body>

</html>