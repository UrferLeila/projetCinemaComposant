<header>
    <nav class="navbar">
        <h1 class="h1">Le Palace</h1>
        <div class="navbar-actions">
            @guest
                <a href="{{ url('/login') }}" class="btn btn-red">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-red">Register</a>
            @endguest
            @auth
                <div class="dropdown">
                    <button class="btn-red dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>
</header>

