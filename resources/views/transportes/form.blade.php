<form method="POST" action="{{ $action }}" class="mx-auto max-w-4xl">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card p-6">
        <div class="grid gap-5 md:grid-cols-2">
            <div><label class="mb-2 block text-sm font-bold">Tipo</label><select name="tipo" class="field" required>@foreach(['Autobus','Avion','Tren','Barco'] as $tipo)<option value="{{ $tipo }}" @selected(old('tipo', $transporte->tipo) === $tipo)>{{ $tipo }}</option>@endforeach</select></div>
            <div><label class="mb-2 block text-sm font-bold">Fecha de salida</label><input name="fecha_salida" value="{{ old('fecha_salida', optional($transporte->fecha_salida)->format('Y-m-d\TH:i')) }}" type="datetime-local" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Origen</label><input name="origen" value="{{ old('origen', $transporte->origen) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Destino</label><input name="destino" value="{{ old('destino', $transporte->destino) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Capacidad</label><input name="capacidad" value="{{ old('capacidad', $transporte->capacidad) }}" type="number" min="1" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Precio</label><input name="precio" value="{{ old('precio', $transporte->precio) }}" type="number" min="0" step="0.01" class="field" required></div>
        </div>
        <div class="mt-6 flex justify-end gap-3"><a href="{{ route('transportes.index') }}" class="btn-light">Cancelar</a><button class="btn-primary">Guardar</button></div>
    </div>
</form>
