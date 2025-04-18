<header>
    <div class="top-nav container">
        <div class="top-nav-left">
            <div class="logo"><a href="/">Ecommerce</a></div>
            
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
                <nav>
                    <ul>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        {{-- <li><a href="{{ route('about') }}">About</a></li> --}}
                        {{-- <li><a href="{{ route('blog.index') }}">Blog</a></li> --}}
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </nav>
            @endif
        </div>
        
        <div class="top-nav-right">
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
                <nav>
                    <ul>
                        @guest
                            <li><a href="{{ route('register') }}">Sign Up</a></li>
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li><a href="{{ route('cart.index') }}">Cart</a></li>
                            <li>
                                <a href="{{ route('users.edit') }}">My Account</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </nav>
            @endif
        </div>
    </div> <!-- end top-nav -->
</header>
