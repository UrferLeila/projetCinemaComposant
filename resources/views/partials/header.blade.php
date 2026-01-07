<header>
    <nav class="navbar">
        <h1 class="h1 logo">Le Palace</h1>
        <div class="navbar-actions">
            @guest
                <a href="{{ route('login') }}" class="btn btn-red">Login</a>
                <a href="{{ route('register') }}" class="btn btn-red">Register</a>
            @endguest

            @auth
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        {{-- <img src="https://picsum.photos/40" alt="Profile Picture" class="profile-pic"> --}}
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <span class="arrow">&#9662;</span>
                    </button>
                    <ul class="profile-menu" id="profileMenu">
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <hr>
                        <li><a href="/vue/resevationList/">Mes réservations</a></li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Se deconnecte</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </nav>
</header>