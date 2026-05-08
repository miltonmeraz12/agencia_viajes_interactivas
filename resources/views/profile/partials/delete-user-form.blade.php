<form method="POST" action="{{ route('profile.destroy') }}" class="card border-red-200 p-6">
    @csrf @method('DELETE')
    <h2 class="text-lg font-extrabold text-red-700">Eliminar cuenta</h2>
    <p class="mt-2 text-sm text-slate-600">Esta accion cerrara tu sesion y eliminara tu usuario.</p>
    <div class="mt-4"><label class="mb-2 block text-sm font-bold">Confirma tu contrasena</label><input name="password" type="password" class="field" required></div>
    <button class="btn-light mt-6 text-red-700" onclick="return confirm('Eliminar definitivamente tu cuenta?')">Eliminar cuenta</button>
</form>
