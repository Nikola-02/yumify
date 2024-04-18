<div class="nav-container">
    <div class="navigation">
        <div class="logo">
            <a href="{{route('home')}}">
                <span class="logo-inside-div">
                    <span class="logo-img">
                        <img src="{{asset('assets/images/yumify-logo.png')}}" alt="Yumify logo"/>
                    </span>
                    <span class="logo-text">
                        <h1>Yumify</h1>
                    </span>
                </span>
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="/restaurants">Restaurants</a>
                </li>
                @if(session('user'))
                    <li>
                        <a href="/order">Cart</a>
                    </li>
                    <li>
                        <a href="/order/history">Order History</a>
                    </li>
                    <li>
                        <a class="user-show">User: <strong>{{session()->get('user')->username}}</strong></a>
                    </li>
                    @if(session('user')['role']['name'] == 'admin')
                        <li >
                            <a class="admin" href="/admin">Admin panel</a>
                        </li>
                    @endif

                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn">Logout</button>
                        </form>
                    </li>

                @else
                    <li>
                        <a href="/register">Register</a>
                    </li>
                    <li>
                        <a class="login-btn" href="/login">Login</a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</div>
