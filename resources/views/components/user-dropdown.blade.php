@auth
    <div class="relative" x-data="{ open: false }">
        {{-- Botón de Perfil --}}
        <button @click="open = !open"
            class="w-[50px] h-[50px] bg-[#3B82F6] rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-blue-600 transition-colors focus:outline-none border-2 border-white/10">
            <svg class="w-8 h-8 text-white mt-1" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </button>

        {{-- Dropdown con el estilo exacto del cliente (#072b4e) --}}
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="absolute right-0 mt-3 w-64 bg-[#072b4e] rounded-2xl shadow-2xl border border-white/10 overflow-hidden z-50 font-nova"
            style="display: none;">

            {{-- Encabezado del Dropdown --}}
            <div class="px-6 py-4 border-b border-white/10 bg-white/5">
                <p class="text-white text-sm font-bold truncate">
                    {{ match (auth()->user()->role) {
                        'operador' => 'Operador',
                        'cliente' => 'Cliente',
                        'administrador' => 'Administrador',
                        default => 'Usuario',
                    } }}
                </p>
                <p class="text-gray-400 text-xs truncate">{{ auth()->user()->email }}</p>
            </div>

            <div class="py-1">
                {{-- Opcion para ver perfil --}}
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm text-gray-200 hover:bg-white/5 transition-colors border-b border-white/10">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-400">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <span>Perfil</span>
                </a>

                {{-- Opción: Cambiar contraseña con Icono --}}
                <a href="{{ route('profile.password') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm text-gray-200 hover:bg-white/5 transition-colors border-b border-white/10">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span>Cambiar contraseña</span>
                </a>

                {{-- Opción: Cerrar Sesión en Rojo con Icono --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-6 py-4 text-sm text-[#f14646] hover:bg-red-500/10 transition-colors flex items-center gap-3 font-bold">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
@endauth
