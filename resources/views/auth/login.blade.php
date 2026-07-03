<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Havre de Paix Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body style="background-color: var(--color-navy); font-family: var(--font-sans);" class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl mx-auto mb-3 flex items-center justify-center text-white font-bold text-xl shadow-xl" style="background-color: var(--color-orange);">HDP</div>
            <h1 class="text-2xl font-bold text-white" style="font-family: var(--font-serif);">Havre de Paix</h1>
            <p class="text-sm mt-1" style="color: rgba(255,255,255,0.5);">Back-office hôtelier</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-lg font-semibold mb-6" style="color: var(--color-navy);">Connexion</h2>

            @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-200">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="form-input" autocomplete="email" required autofocus>
                </div>
                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password"
                           class="form-input" autocomplete="current-password" required>
                </div>
                <label class="flex items-center gap-2 text-sm cursor-pointer" style="color: var(--color-slate);">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded" style="accent-color: var(--color-orange);">
                    Se souvenir de moi
                </label>
                <button type="submit" class="btn-primary w-full py-3">Se connecter</button>
            </form>
        </div>

        <p class="text-center mt-6 text-sm">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors" style="color: rgba(255,255,255,0.5);">← Retour au site</a>
        </p>
    </div>
</body>
</html>
