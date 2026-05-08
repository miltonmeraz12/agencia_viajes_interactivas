<form method="POST" action="{{ route('password.update') }}" class="card p-6">
    @csrf @method('PUT')
    <h2 class="text-lg font-extrabold">Cambiar contrasena</h2>
    <div class="mt-5 space-y-4">
        <div><label class="mb-2 block text-sm font-bold">Contrasena actual</label><input name="current_password" type="password" class="field" required></div>
        <div><label class="mb-2 block text-sm font-bold">Nueva contrasena</label><input name="password" type="password" class="field" required></div>
        <div><label class="mb-2 block text-sm font-bold">Confirmar contrasena</label><input name="password_confirmation" type="password" class="field" required></div>
    </div>
    <button class="btn-primary mt-6">Guardar contrasena</button>
</form>
