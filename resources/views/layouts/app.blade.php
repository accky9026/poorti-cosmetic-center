<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Poorti Cosmetic Center')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --plum: #E0417B;        /* vibrant raspberry pink - primary */
            --plum-dark: #9C1F52;   /* deep magenta - primary hover/dark */
            --blush: #FFE1EC;       /* soft pink surface */
            --gold: #FFB200;        /* vivid marigold - accent */
            --gold-soft: #FFDD8A;   /* light gold */
            --violet: #7B2CBF;      /* extra accent - featured/violet badges */
            --mint: #06D6A0;        /* success/delivered */
            --ink: #2E1A2F;
            --paper: #FFF8F3;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Jost', sans-serif;
            background: var(--paper);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .display {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        a { text-decoration: none; color: inherit; }

        .container { width: 100%; max-width: 1140px; margin: 0 auto; padding: 0 20px; }

        /* ---- Top utility bar ---- */
        .topbar {
            background: linear-gradient(90deg, var(--plum-dark), var(--violet));
            color: var(--gold-soft);
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-align: center;
            padding: 7px 10px;
        }

        /* ---- Navbar ---- */
        .navbar {
            background: var(--paper);
            border-bottom: 1px solid #eee0d8;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-mark {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, var(--gold-soft), var(--gold) 60%, var(--plum) 100%);
            flex-shrink: 0;
        }
        .brand-text .name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(120deg, var(--plum), var(--violet));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .brand-text .tag {
            font-size: 0.66rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
        }
        .nav-links { display: flex; gap: 28px; font-size: 0.92rem; font-weight: 500; }
        .nav-links a { color: var(--ink); position: relative; padding-bottom: 4px; }
        .nav-links a:hover { color: var(--plum); }
        .btn-admin {
            border: 1px solid var(--plum);
            color: var(--plum);
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 0.85rem;
        }
        .btn-admin:hover { background: var(--plum); color: #fff; }

        .nav-actions { display: flex; align-items: center; gap: 14px; }
        .nav-link-plain { font-size: 0.88rem; font-weight: 500; color: var(--ink); }
        .nav-link-plain:hover { color: var(--plum); }
        .cart-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--plum-dark);
        }
        .cart-count {
            background: var(--gold);
            color: #fff;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 10px;
        }
        .logout-link {
            background: none;
            border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            padding: 0;
        }
        .logout-link:hover { color: #a3324c; }

        /* ---- Buttons ---- */
        .btn {
            display: inline-block;
            padding: 11px 26px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
        }
        .btn-primary { background: linear-gradient(135deg, var(--plum), var(--violet)); color: #fff; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--plum-dark), var(--violet)); }
        .btn-gold { background: linear-gradient(135deg, var(--gold), #FF8A5B); color: #fff; }
        .btn-gold:hover { background: linear-gradient(135deg, #E69E00, #FF6B3D); }
        .btn-outline { border: 1px solid var(--plum); color: var(--plum); background: transparent; }
        .btn-outline:hover { background: var(--plum); color: #fff; }
        .btn-danger { background: linear-gradient(135deg, #F4436C, #C9184A); color: #fff; }
        .btn-danger:hover { background: linear-gradient(135deg, #C9184A, #9C1F52); }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }

        /* ---- Scallop divider (signature element) ---- */
        .scallop {
            height: 22px;
            width: 100%;
            background-image: radial-gradient(circle at 10px -6px, transparent 12px, var(--paper) 13px);
            background-size: 24px 22px;
            background-position: center top;
            background-repeat: repeat-x;
        }
        .scallop-plum {
            background-image: radial-gradient(circle at 10px -6px, transparent 12px, var(--plum) 13px);
        }

        /* ---- Alerts ---- */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 0.92rem;
        }
        .alert-success { background: #e6f4ea; color: #256a3d; border: 1px solid #bfe3cb; }
        .alert-danger { background: #fbe9ec; color: #8a2338; border: 1px solid #f3c4cd; }

        /* ---- Footer ---- */
        footer {
            background: var(--plum-dark);
            color: #f1e3ea;
            margin-top: 60px;
        }
        footer .container { padding: 46px 20px 26px; }
        footer h4 {
            font-family: 'Cormorant Garamond', serif;
            color: var(--gold-soft);
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
        footer p, footer li { font-size: 0.9rem; color: #dcc9d3; line-height: 1.7; }
        footer .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 30px;
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.12);
            text-align: center;
            padding: 16px 0;
            font-size: 0.8rem;
            color: #c7aebb;
        }

        table.admin-table { width: 100%; border-collapse: collapse; background: #fff; }
        table.admin-table th {
            background: var(--blush);
            color: var(--plum-dark);
            text-align: left;
            padding: 12px 14px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        table.admin-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1e6ec;
            font-size: 0.92rem;
            vertical-align: middle;
        }
        table.admin-table tr:hover td { background: #fdf7f9; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
        }
        .badge-plum { background: var(--blush); color: var(--plum); }
        .badge-low { background: #FFE1E1; color: #C9184A; }
        .badge-ok { background: #D6F9EE; color: #06895D; }
        .badge-pending { background: #F1E4FB; color: var(--violet); }
        .badge-confirmed { background: #DCEBFF; color: #1D5FCB; }
        .badge-packed { background: #FFF1CC; color: #B36B00; }
        .badge-delivered { background: #D6F9EE; color: #06895D; }
        .badge-cancelled { background: #FFE1E1; color: #C9184A; }

        .form-control-wrap { margin-bottom: 18px; }
        label.field-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--plum-dark);
        }
        input[type=text], input[type=number], input[type=file], textarea, select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #e6d7de;
            border-radius: 8px;
            font-family: 'Jost', sans-serif;
            font-size: 0.93rem;
            background: #fff;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--plum);
            box-shadow: 0 0 0 3px rgba(92,33,64,0.1);
        }
        .checkbox-row { display: flex; align-items: center; gap: 8px; }
        .checkbox-row input { width: auto; }
        .error-text { color: #a3324c; font-size: 0.78rem; margin-top: 5px; }

        .card-panel {
            background: #fff;
            border: 1px solid #f1e6ec;
            border-radius: 14px;
            padding: 28px;
        }

        @media (max-width: 860px) {
            .nav-links { display: none; }
            footer .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
    @yield('head')
</head>
<body>

    <div class="topbar">✦ Free Shipping in Kanpur Nagar on Orders Above ₹499 ✦</div>

    <nav class="navbar">
        <div class="container navbar-inner">
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-mark"></div>
                <div class="brand-text">
                    <div class="name">Poorti Cosmetic Center</div>
                    <div class="tag">Beauty · Skin · Glow</div>
                </div>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Shop</a>
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('home') }}#contact">Contact</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.orders.index') }}">Bills</a>
                    @else
                        <a href="{{ route('orders.index') }}">My Orders</a>
                    @endif
                @endauth
            </div>
            <div class="nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="nav-link-plain">Login</a>
                    <a href="{{ route('register') }}" class="btn-admin">Sign Up</a>
                @else
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('products.index') }}" class="btn-admin">Admin Panel</a>
                    @else
                        <a href="{{ route('cart.index') }}" class="cart-link">
                            🛍 Cart
                            @if(\App\Services\CartService::count() > 0)
                                <span class="cart-count">{{ \App\Services\CartService::count() }}</span>
                            @endif
                        </a>
                    @endif
                    <span class="nav-link-plain" style="color:#8a7580;">Hi, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-link">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main>
        @if (session('success'))
            <div class="container" style="padding-top:20px;">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="container" style="padding-top:20px;">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h4>Poorti Cosmetic Center</h4>
                    <p>Your neighbourhood destination for genuine skincare, makeup, haircare and fragrance — handpicked for every skin tone and budget.</p>
                </div>
                <div>
                    <h4>Visit Us</h4>
                    <p>
                        Khanday Ray Ka Purwa,<br>
                        Binaur, Sachendi,<br>
                        Kanpur Nagar, Uttar Pradesh
                    </p>
                </div>
                <div>
                    <h4>Store Hours</h4>
                    <p>Mon – Sat: 10:00 AM – 8:30 PM<br>Sunday: 11:00 AM – 6:00 PM</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} Poorti Cosmetic Center, Sachendi, Kanpur Nagar. All rights reserved.
        </div>
    </footer>

</body>
</html>
