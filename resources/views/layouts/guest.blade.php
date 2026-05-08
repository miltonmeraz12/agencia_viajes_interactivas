<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Agencia de Viajes') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="grid min-h-screen place-items-center px-4 py-10">
        <div class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <a href="{{ route('home') }}" class="mb-6 flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-teal-700 text-white"><i class="fa-solid fa-plane-departure"></i></span>
                <span class="font-extrabold">Agencia de Viajes</span>
            </a>
            {{ $slot }}
        </div>
    </div>
</body>
</html>
