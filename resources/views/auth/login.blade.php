<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Acceso</p>
        <h1 class="mt-2 text-2xl font-extrabold">Iniciar sesion</h1>
        <p class="mt-2 text-sm text-slate-500">Entra para comprar paquetes, administrar catalogos o revisar tus reservaciones.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-bold">Correo</label>
            <input name="email" value="{{ old('email') }}" type="email" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold">Contrasena</label>
            <input name="password" type="password" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2"><input type="checkbox" name="remember"> Recordarme</label>
            <a href="{{ route('password.request') }}" class="font-bold text-teal-700">Olvide mi contrasena</a>
        </div>
        <button class="w-full rounded-lg bg-teal-700 px-4 py-3 font-bold text-white hover:bg-teal-800">Entrar</button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-500">No tienes cuenta? <a href="{{ route('register') }}" class="font-bold text-teal-700">Registrate</a></p>
    <div class="mt-6 rounded-lg bg-slate-50 p-4 text-xs text-slate-600">
        <p class="font-bold text-slate-800">Accesos de prueba</p>
        <p>Admin: admin@agencia.com / password</p>
        <p>Usuario: usuario@agencia.com / password</p>
    </div>
</x-guest-layout>
