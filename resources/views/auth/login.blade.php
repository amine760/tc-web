@extends('layouts/app')

@section('title', 'Login')

@section('content')
    <div class="auth-wrapper-bichou">
        <div class="auth-wrapper">
            <div class="glass-card">
                <h1 class="title">Login</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-field">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder=" " autofocus>
                        <label for="email">Email</label>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <input id="password" type="password" name="password" required placeholder=" ">
                        <label for="password">mot de passe</label>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Se souvenir de moi</label>
                    </div>

                    <button type="submit" class="purple-button">Login</button>

                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            Mot de passe oublier
                        </a>
                    @endif
                </form>

                <div class="footer-link">
                    S'inscrire? <a href="{{ route('register') }}">Creer un compte ici</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-wrapper-bichou {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f4f4f9, #ffffff);
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            width: 100%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(200, 200, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(128, 0, 255, 0.1);
            backdrop-filter: blur(10px);
            animation: popIn 0.5s ease;
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
            color: #6c63ff;
            font-weight: bold;
        }

        .form-field {
            position: relative;
            margin-bottom: 25px;
        }

        .form-field input {
            width: 100%;
            padding: 14px 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
            color: #333;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-field input:focus {
            outline: none;
            border-color: #a78bfa;
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.3);
        }

        .form-field label {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
            transition: 0.2s ease all;
            background: white;
            padding: 0 5px;
        }

        .form-field input:focus+label,
        .form-field input:not(:placeholder-shown)+label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #6c63ff;
        }

        .error {
            display: block;
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .purple-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(to right, #a78bfa, #7c3aed);
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .purple-button:hover {
            box-shadow: 0 0 10px #a78bfa, 0 0 20px #7c3aed;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
            color: #6c63ff;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-link a {
            color: #6c63ff;
            font-weight: 500;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
