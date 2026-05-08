<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mx-auto max-w-4xl">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div><label class="mb-2 block text-sm font-bold">Nombre</label><input name="nombre" value="{{ old('nombre', $destino->nombre) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Pais</label><input name="pais" value="{{ old('pais', $destino->pais) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Direccion</label><input name="direccion" value="{{ old('direccion', $destino->direccion) }}" class="field"></div>
            <div><label class="mb-2 block text-sm font-bold">Precio base</label><input name="precio_base" value="{{ old('precio_base', $destino->precio_base) }}" type="number" min="0" step="0.01" class="field" required></div>
            <div class="md:col-span-2"><label class="mb-2 block text-sm font-bold">Descripcion</label><textarea name="descripcion" rows="5" class="field" required>{{ old('descripcion', $destino->descripcion) }}</textarea></div>
            <div><label class="mb-2 block text-sm font-bold">Galeria</label><input name="imagenes[]" type="file" multiple accept="image/*" class="field"></div>
            <label class="flex items-center gap-2 pt-8 text-sm font-bold"><input name="activo" value="1" type="checkbox" @checked(old('activo', $destino->activo))> Activo</label>
        </div>
        <div class="mt-6 flex justify-end gap-3"><a href="{{ route('destinos.index') }}" class="btn-light">Cancelar</a><button class="btn-primary">Guardar</button></div>
    </div>
</form>
