@extends('layouts/app')

@section('title', 'Edit Profile')

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    style="background: red; color:white; border: none; cursor: pointer; font: inherit; padding: 10px;">Déconnexion</button>
            </form>
            <h1>Profil Utilisateur</h1>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="prenom">Nom</label>
                    <input id="prenom" type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                </div>

                <div class="form-group">
                    <label for="nom">Prénom</label>
                    <input id="nom" type="text" name="nom" value="{{ old('nom', $user->nom) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn-update">Mettre a jour les informations générales</button>
            </form>
            <div class="password-update-section">
                <h3>Changer son Password</h3>
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" required class="form-control">
                        @error('current_password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nouveau Mot de passe</label>
                        <input type="password" id="new_password" name="new_password" required minlength="8"
                            class="form-control">
                        @error('new_password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
                            class="form-control">
                    </div>

                    <button type="submit" class="btn-update">Modifier le mot de passe</button>
                </form>
            </div>

            <div class="address-section">
                <h2>Adresses</h2>

                @foreach ($addresses as $address)
                    <div class="address-card">
                        <p>{{ $address->address }}</p>
                        <div class="address-actions">
                            <form action="{{ route('address.delete', $address) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Suprimmer</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <h3>Ajouter une adress</h3>
                <form action="{{ route('address.add') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="address" required placeholder="Enter your address"></textarea>
                    </div>
                    <button type="submit" class="btn-add">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px 20px;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 1000px;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.2s ease-in-out;
        }

        h1,
        h2,
        h3 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            padding: 12px 15px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-update,
        .btn-add,
        .btn-set-default {
            background: #ffffff22;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-delete {
            background: red;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-update:hover,
        .btn-add:hover,
        .btn-set-default:hover {
            background: #ffffff44;
            transform: scale(1.05);
        }

        .password-update-section,
        .address-section {
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 30px;
        }

        .address-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 15px;
            position: relative;
            color: white;
        }

        .address-card.default {
            border: 2px solid lime;
        }

        .address-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .default-badge {
            background: limegreen;
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.85em;
            color: black;
        }

        .form-check {
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.9em;
            margin-top: 5px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 20px;
            }

            .address-actions {
                flex-direction: column;
            }
        }
    </style>

@endsection
