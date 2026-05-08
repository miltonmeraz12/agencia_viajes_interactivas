<form method="POST" action="{{ $action }}" class="mx-auto max-w-4xl">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-bold">Nombre del paquete</label>
                <input name="nombre" value="{{ old('nombre', $viaje->nombre) }}" class="field" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Destino</label>
                <select name="destino_id" class="field" required>
                    <option value="">Selecciona destino</option>
                    @foreach($destinos as $destino)
                        <option value="{{ $destino->id }}" @selected(old('destino_id', $viaje->destino_id) == $destino->id)>{{ $destino->nombre }} - {{ $destino->pais }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Hospedaje</label>
                <select name="hospedaje_id" class="field">
                    <option value="">Sin hospedaje</option>
                    @foreach($hospedajes as $hospedaje)
                        <option value="{{ $hospedaje->id }}" @selected(old('hospedaje_id', $viaje->hospedaje_id) == $hospedaje->id)>{{ $hospedaje->nombre }} - {{ $hospedaje->destino->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Transporte</label>
                <select name="transporte_id" class="field" required>
                    <option value="">Selecciona transporte</option>
                    @foreach($transportes as $transporte)
                        <option value="{{ $transporte->id }}" @selected(old('transporte_id', $viaje->transporte_id) == $transporte->id)>{{ $transporte->tipo }} - {{ $transporte->origen }} a {{ $transporte->destino }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Precio total</label>
                <input name="precio_total" value="{{ old('precio_total', $viaje->precio_total) }}" type="number" min="1" step="0.01" class="field" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Fecha salida</label>
                <input name="fecha_inicio" value="{{ old('fecha_inicio', optional($viaje->fecha_inicio)->format('Y-m-d')) }}" type="date" class="field" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Fecha regreso</label>
                <input name="fecha_fin" value="{{ old('fecha_fin', optional($viaje->fecha_fin)->format('Y-m-d')) }}" type="date" class="field" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold">Capacidad</label>
                <input name="capacidad" value="{{ old('capacidad', $viaje->capacidad) }}" type="number" min="1" class="field" required>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('viajes.index') }}" class="btn-light">Cancelar</a>
            <button class="btn-primary">Guardar paquete</button>
        </div>
    </div>
</form>
