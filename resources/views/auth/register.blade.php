@extends('layouts.app')

@section('title', 'Create Account - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 60px 0; max-width:440px;">

    <div style="text-align:center; margin-bottom:26px;">
        <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Join Us</div>
        <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Create Account</h1>
    </div>

    <div class="card-panel">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-control-wrap">
                <label class="field-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name" autofocus>
            </div>
            <div class="form-control-wrap">
                <label class="field-label">Email</label>
                <input type="text" name="email" value="{{ old('email') }}" placeholder="you@example.com">
            </div>
            <div class="form-control-wrap">
                <label class="field-label">WhatsApp / Mobile Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210">
            </div>
            <div class="form-control-wrap">
                <label class="field-label">Password</label>
                <input type="password" name="password" placeholder="At least 6 characters">
            </div>
            <div class="form-control-wrap">
                <label class="field-label">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Re-enter password">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Create Account</button>
        </form>

        <p style="text-align:center; margin-top:18px; font-size:0.9rem; color:#5a4a52;">
            Already have an account? <a href="{{ route('login') }}" style="color:var(--plum); font-weight:500;">Login</a>
        </p>
    </div>

</div>
@endsection
