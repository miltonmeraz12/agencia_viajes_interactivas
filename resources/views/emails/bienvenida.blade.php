<x-mail::message>
# Bienvenido, {{ $user->name }}

Tu cuenta fue creada correctamente. Desde tu panel puedes explorar paquetes, comprar viajes y descargar tus tickets PDF.

<x-mail::button :url="route('login')">
Iniciar sesion
</x-mail::button>

Gracias por confiar en Agencia de Viajes.
</x-mail::message>
