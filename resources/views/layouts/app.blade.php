<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Agencia de Viajes') }} - @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: Inter, system-ui, sans-serif; }
        .nav-link { display:flex; align-items:center; gap:.75rem; padding:.7rem .85rem; border-radius:.5rem; color:#cbd5e1; font-size:.875rem; font-weight:600; }
        .nav-link:hover { background:rgba(255,255,255,.08); color:#fff; }
        .nav-link.active { background:#f59e0b; color:#111827; }
        .field { width:100%; border:1px solid #cbd5e1; border-radius:.5rem; padding:.7rem .85rem; background:white; color:#0f172a; }
        .field:focus { outline:none; border-color:#0f766e; box-shadow:0 0 0 3px rgba(15,118,110,.12); }
        .btn-primary { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; background:#0f766e; color:white; font-weight:700; border-radius:.5rem; padding:.7rem 1rem; }
        .btn-primary:hover { background:#115e59; }
        .btn-dark { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; background:#111827; color:white; font-weight:700; border-radius:.5rem; padding:.7rem 1rem; }
        .btn-light { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; background:white; color:#334155; font-weight:700; border:1px solid #cbd5e1; border-radius:.5rem; padding:.7rem 1rem; }
        .card { background:white; border:1px solid #e2e8f0; border-radius:.5rem; box-shadow:0 1px 2px rgba(15,23,42,.04); }
        .badge { display:inline-flex; align-items:center; border-radius:.375rem; padding:.25rem .5rem; font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.04em; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen lg:flex">
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 h-screen w-72 shrink-0 -translate-x-full bg-slate-950 text-white transition lg:sticky lg:top-0 lg:translate-x-0">
            <div class="flex h-full flex-col">
                <div class="border-b border-white/10 p-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-lg bg-amber-500 text-slate-950">
                            <i class="fa-solid fa-plane-departure"></i>
                        </span>
                        <span>
                            <span class="block text-lg font-extrabold">Agencia de Viajes</span>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Interactivas</span>
                        </span>
                    </a>
                </div>

                <nav class="flex-1 space-y-1 overflow-y-auto p-4">
                    <p class="px-3 py-2 text-xs font-bold uppercase tracking-widest text-slate-500">Catalogo</p>
                    <a href="{{ route('viajes.catalogo') }}" class="nav-link {{ request()->routeIs('home', 'viajes.catalogo*') ? 'active' : '' }}"><i class="fa-solid fa-suitcase w-5"></i> Paquetes</a>
                    @auth
                        <a href="{{ route('destinos.index') }}" class="nav-link {{ request()->routeIs('destinos.*') ? 'active' : '' }}"><i class="fa-solid fa-map-location-dot w-5"></i> Destinos</a>
                        <a href="{{ route('hospedajes.index') }}" class="nav-link {{ request()->routeIs('hospedajes.*') ? 'active' : '' }}"><i class="fa-solid fa-hotel w-5"></i> Hospedajes</a>
                        <a href="{{ route('reservaciones.index') }}" class="nav-link {{ request()->routeIs('reservaciones.*') ? 'active' : '' }}"><i class="fa-solid fa-ticket w-5"></i> Reservaciones</a>
                    @endauth

                    @auth
                        @if(auth()->user()->isAdmin())
                            <p class="px-3 pb-2 pt-6 text-xs font-bold uppercase tracking-widest text-slate-500">Administracion</p>
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line w-5"></i> Dashboard</a>
                            <a href="{{ route('viajes.index') }}" class="nav-link {{ request()->routeIs('viajes.index', 'viajes.create', 'viajes.edit', 'viajes.show') ? 'active' : '' }}"><i class="fa-solid fa-box-open w-5"></i> Gestion paquetes</a>
                            <a href="{{ route('transportes.index') }}" class="nav-link {{ request()->routeIs('transportes.*') ? 'active' : '' }}"><i class="fa-solid fa-bus w-5"></i> Transportes</a>
                            <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear w-5"></i> Usuarios</a>
                        @else
                            <p class="px-3 pb-2 pt-6 text-xs font-bold uppercase tracking-widest text-slate-500">Mi cuenta</p>
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house w-5"></i> Inicio</a>
                        @endif
                    @endauth
                </nav>

                <div class="border-t border-white/10 p-4">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="mb-3 flex items-center gap-3 rounded-lg border border-white/10 p-3 hover:bg-white/5">
                            <span class="grid h-9 w-9 place-items-center rounded-lg bg-white text-sm font-extrabold text-slate-950">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-bold">{{ auth()->user()->name }}</span>
                                <span class="block text-xs uppercase tracking-wider text-slate-400">{{ auth()->user()->role }}</span>
                            </span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full rounded-lg px-3 py-2 text-left text-sm font-bold text-slate-300 hover:bg-red-500/10 hover:text-red-200">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar sesion
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('login') }}" class="btn-light !bg-white/10 !text-white !border-white/10">Entrar</a>
                            <a href="{{ route('register') }}" class="btn-primary">Registro</a>
                        </div>
                    @endauth
                </div>
            </div>
        </aside>

        <div id="overlay" class="fixed inset-0 z-30 hidden bg-slate-950/60 lg:hidden" onclick="toggleSidebar()"></div>

        <div class="min-w-0 flex-1">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 px-4 py-3 backdrop-blur lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <button class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 lg:hidden" onclick="toggleSidebar()">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <p class="text-sm font-bold text-slate-500">@yield('eyebrow', 'Sistema de Agencia de Viajes')</p>
                        <h1 class="text-xl font-extrabold text-slate-950">@yield('page-title', 'Panel')</h1>
                    </div>
                    @auth
                        <a href="{{ route('profile.edit') }}" class="hidden text-sm font-bold text-slate-600 hover:text-teal-700 sm:block">{{ auth()->user()->email }}</a>
                    @endauth
                </div>
            </header>

            <main class="p-4 lg:p-8">
                @foreach(['success' => 'emerald', 'error' => 'red', 'warning' => 'amber'] as $key => $color)
                    @if(session($key))
                        <div class="mb-5 rounded-lg border border-{{ $color }}-200 bg-{{ $color }}-50 p-4 text-sm font-semibold text-{{ $color }}-900">
                            {{ session($key) }}
                        </div>
                    @endif
                @endforeach

                @if(session('import_errors'))
                    <div class="mb-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                        <p class="mb-2 font-bold">Errores detectados en el archivo:</p>
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                        <p class="mb-2 font-bold">Revisa los campos:</p>
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
