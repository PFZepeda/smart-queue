<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso denegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#0C4D8B] text-white antialiased">
    <main class="min-h-screen flex items-center justify-center px-4">
        <section class="w-full max-w-xl bg-[#072b4e] border border-white/10 rounded-3xl shadow-2xl p-8 sm:p-10 text-center">
            <h1 class="text-2xl sm:text-3xl font-bold text-red-300 mb-3">Acceso denegado</h1>
            <p class="text-sm sm:text-base text-gray-200 mb-7">
                No tienes permisos para entrar a esta seccion. Si llegaste aqui por URL o por error,
                vuelve a tu panel correspondiente.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                @auth
                    @php
                        $homeRoute = auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : (auth()->user()->isOperador() ? route('advisor.dashboard') : route('nova.index'));
                    @endphp
                    <a href="{{ $homeRoute }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#02B48A] hover:bg-[#019875] px-6 py-3 font-semibold transition-colors">
                        Ir a mi panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#02B48A] hover:bg-[#019875] px-6 py-3 font-semibold transition-colors">
                        Ir a iniciar sesion
                    </a>
                @endauth

                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 px-6 py-3 font-semibold transition-colors">
                    Regresar
                </a>
            </div>
        </section>
    </main>
</body>
</html>
