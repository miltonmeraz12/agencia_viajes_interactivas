<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mx-auto max-w-4xl">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2"><label class="mb-2 block text-sm font-bold">Destino</label><select name="destino_id" class="field" required><option value="">Selecciona destino</option>@foreach($destinos as $destino)<option value="{{ $destino->id }}" @selected(old('destino_id', $hospedaje->destino_id) == $destino->id)>{{ $destino->nombre }} - {{ $destino->pais }}</option>@endforeach</select></div>
            <div><label class="mb-2 block text-sm font-bold">Nombre</label><input name="nombre" value="{{ old('nombre', $hospedaje->nombre) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Categoria</label><select name="categoria" class="field" required>@foreach(['hotel','hostal','resort'] as $cat)<option value="{{ $cat }}" @selected(old('categoria', $hospedaje->categoria) === $cat)>{{ ucfirst($cat) }}</option>@endforeach</select></div>
            <div><label class="mb-2 block text-sm font-bold">Direccion</label><input name="direccion" value="{{ old('direccion', $hospedaje->direccion) }}" class="field"></div>
            <div><label class="mb-2 block text-sm font-bold">Precio por noche</label><input name="precio_noche" value="{{ old('precio_noche', $hospedaje->precio_noche) }}" type="number" min="0" step="0.01" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Habitaciones disponibles</label><input name="habitaciones_disp" value="{{ old('habitaciones_disp', $hospedaje->habitaciones_disp) }}" type="number" min="0" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Imagenes</label><input name="imagenes[]" type="file" multiple accept="image/*" class="field"></div>
        </div>
        <div class="mt-6 flex justify-end gap-3"><a href="{{ route('hospedajes.index') }}" class="btn-light">Cancelar</a><button class="btn-primary">Guardar</button></div>
    </div>
</form>
