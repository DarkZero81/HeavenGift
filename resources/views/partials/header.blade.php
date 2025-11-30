<nav class="navbar navbar-expand-lg ">
    <div class="container">
        <img width="60" height="60" src="https://img.icons8.com/fluency/48/gift.png" alt="gift" class="me-2" />
        <a class="navbar-brand text-lg-light fs-1" id="title" href="{{ url('/') }}">Gift Heaven</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
            aria-controls="nav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link  text-light fs-3" id="title"
                        href="{{ route('products.index') }}">Shop</a>
                </li>
                <li class="nav-item"><a class="nav-link text-light fs-3" id="title"
                        href="{{ route('contact') }}">Contact</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link text-white fs-3" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-light fs-3" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link text-white fs-4" href="#">Hi,
                            {{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fs-4" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit()">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
                @endguest
                <li class="nav-item"><a class="nav-link text-white fs-4" href="{{ route('cart.index') }}">Cart</a></li>
            </ul>
        </div>
    </div>
</nav>
