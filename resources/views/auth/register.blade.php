<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Registro de cliente</p>
        <h1 class="mt-2 text-2xl font-extrabold">Crear cuenta</h1>
        <p class="mt-2 text-sm text-slate-500">Tu cuenta se creara con rol de usuario para comprar paquetes y consultar tickets.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-bold">Nombre completo</label>
            <input name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold">Correo</label>
            <input name="email" value="{{ old('email') }}" type="email" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold">Telefono</label>
            <input name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-300 px-3 py-3" autocomplete="tel">
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold">Contrasena</label>
                <input name="password" type="password" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Confirmar</label>
                <input name="password_confirmation" type="password" class="w-full rounded-lg border border-slate-300 px-3 py-3" required autocomplete="new-password">
            </div>
        </div>
        <button class="w-full rounded-lg bg-teal-700 px-4 py-3 font-bold text-white hover:bg-teal-800">Crear cuenta</button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-500">Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-teal-700">Inicia sesion</a></p>
</x-guest-layout>
