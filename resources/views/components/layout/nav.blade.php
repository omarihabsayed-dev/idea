<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="{{ route('home') }}" class="text-2xl font-bold">Idea</a>
        </div>
        <div class="flex gap-x-5 items-center">
            @auth
                <a href="{{ route('profile.edit') }}">Edit Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button>Log Out</button>
                </form>
            @endauth
            @guest
                <a href="/login">Login</a>
                <a href="{{ route('register') }}" class="btn">Register</a>   
            @endguest
        </div>
    </div>
</nav>