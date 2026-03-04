<nav class="main-nav">

    <div class="nav-container">

        <!-- LEFT -->
       <div class="nav-left">

    <a href="{{ route('home') }}">Home</a>

<a href="{{ route('stories.index') }}">Istorijos</a>

</div>

        <!-- RIGHT -->
        <div class="nav-right">

            @auth

                <a href="/dashboard">
                    Dashboard
                </a>

                @if(!auth()->user()->story)
                    <a href="{{ route('story.create') }}">
                        Sukurti istoriją
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.stories') }}">
                        Admin
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}">
                    Login
                </a>

                <a href="{{ route('register') }}">
                    Register
                </a>

            @endauth

        </div>

    </div>

</nav>