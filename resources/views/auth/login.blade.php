@extends('layouts.app')

@section('title', 'Login - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 60px 0; max-width:440px;">

    <div style="text-align:center; margin-bottom:26px;">
        <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Welcome Back</div>
        <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Login</h1>
    </div>

    <div class="card-panel">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-control-wrap">
                <label class="field-label">Email</label>
                <input type="text" name="email" value="{{ old('email') }}" placeholder="you@example.com" autofocus>
            </div>
            <div class="form-control-wrap">
                <label class="field-label">Password</label>
                <input type="password" name="password" placeholder="••••••••">
            </div>
            <div class="checkbox-row form-control-wrap">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin:0; font-size:0.88rem;">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
        </form>

        <p style="text-align:center; margin-top:18px; font-size:0.9rem; color:#5a4a52;">
            New to Poorti Cosmetic Center? <a href="{{ route('register') }}" style="color:var(--plum); font-weight:500;">Create an account</a>
        </p>

        <p style="text-align:center; margin-top:6px; font-size:0.78rem; color:#aaa;">
            Shop admin? Log in with your admin email to reach the Admin Panel automatically.
        </p>
    </div>

</div>
@endsection
