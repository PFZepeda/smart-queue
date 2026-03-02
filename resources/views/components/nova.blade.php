<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaBank - Sistema de Turnos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Asegúrate de que AlpineJS esté cargando correctamente --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
    </style>
</head>
<body class="antialiased">

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">
        
        {{-- HEADER --}}
        <header class="flex justify-between items-center px-12 py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[200px] h-auto">
            </div>
            
            @auth
            {{-- BOTÓN DE USUARIO --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="w-[60px] h-[60px] bg-[#3B82F6] rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-blue-600 transition-all focus:outline-none z-">
                    <svg class="w-10 h-10 text-white mt-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </button>

                {{-- DROPDOWN: Estilo exacto a la imagen (Sin info de usuario, sin iconos) --}}
                <div x-show="open" 
                    @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-150" 
                    x-transition:enter-start="opacity-0 scale-95" 
                    x-transition:enter-end="opacity-100 scale-100" 
                    {{-- Posicionamiento ajustado para que "abrace" el botón como en tu imagen --}}
                    class="absolute right-0 mt-2 w-64 bg-[#072b4e] rounded-[2.5rem] shadow-2xl z- py-8 px-10 border border-white/5" 
                    style="display: none;">
                    
                    <div class="flex flex-col space-y-5 text-left">
                        {{-- Opción 1 --}}
                        <a href="{{ route('profile.edit') }}" class="text-white text-lg font-medium hover:text-gray-300 transition-colors">
                            Ajustes de Perfil
                        </a>

                        {{-- Opción 2 --}}
                        <a href="{{ route('profile.password') }}" class="text-white text-lg font-medium hover:text-gray-300 transition-colors">
                            Cambiar contraseña
                        </a>

                        {{-- Opción 3 (Cerrar Sesión) --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white text-lg font-medium hover:text-red-400 transition-colors text-left w-full">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth
        </header>

        {{-- CONTENIDO DINÁMICO --}}
        <main>
            {{ $slot }}
        </main>

    </div>
</body>
</html>
