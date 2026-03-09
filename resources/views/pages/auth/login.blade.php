<x-layouts::auth>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
        
        /* Ocultar el ojo nativo de Edge e Internet Explorer */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
        /* Ocultar el ojo nativo de navegadores Webkit (Chrome, Safari, Edge moderno) */
        input[type="password"]::-webkit-reveal,
        input[type="password"]::-webkit-clear-button {
            display: none !important;
        }

        @media (max-height: 740px) {
            .auth-login-wrapper {
                justify-content: flex-start;
            }
        }
    </style>

    {{-- Notificación slide-in: cuenta eliminada --}}
    @if (session('account_deleted'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="fixed top-4 right-4 left-4 sm:left-auto sm:top-6 sm:right-6 z-[100] flex items-center gap-3 sm:gap-4 bg-[#072b4e] text-white px-4 sm:px-6 py-3 sm:py-4 rounded-2xl shadow-2xl border border-white/5 max-w-sm"
        >
            {{-- Icono X rojo --}}
            <span class="flex-shrink-0 bg-[#0f1c2e] rounded-xl p-2">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
            <span class="font-bold text-sm sm:text-base leading-snug">Tu cuenta ha sido eliminada con éxito</span>
        </div>
    @endif

    <div class="auth-login-wrapper fixed inset-0 flex flex-col items-center justify-center bg-[#0C4D8B] z-50 font-['Source_Sans_3'] overflow-y-auto px-4 py-6 sm:px-6 sm:py-8 md:py-10">
        
        {{-- LOGO: Ajustado a 220px para coincidir --}}
        <div class="mb-6 sm:mb-8 md:mb-10 text-center flex flex-col items-center">
            <img 
                src="{{ asset('images/Logo_1.svg') }}" 
                alt="Logo NovaBank" 
                class="w-[160px] sm:w-[190px] md:w-[220px] h-auto object-contain"
            >
        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div class="w-full max-w-[440px] min-h-[500px] sm:min-h-[520px] md:min-h-[540px] flex flex-col justify-between bg-[#072b4e] px-5 sm:px-8 md:px-10 py-7 sm:py-10 md:py-12 rounded-[1.2rem] sm:rounded-[1.4rem] md:rounded-[1.5rem] shadow-2xl border border-white/5">
            
            <div class="w-full">
                <h2 class="text-white text-center text-[1.05rem] sm:text-[1.1rem] md:text-[1.15rem] font-normal mb-3 sm:mb-4 tracking-wide">
                    Bienvenido
                </h2>

                <p class="text-gray-400 text-[11px] sm:text-[12px] text-center mb-5 sm:mb-6">Los campos obligatorios tienen <span class="text-red-400">*</span></p>

                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col">
                    @csrf

                    {{-- Campo Correo --}}
                    <div class="mb-4 sm:mb-5">
                        <label class="block text-gray-300 text-[12px] sm:text-[13px] mb-2" for="email">Correo electrónico <span class="text-red-400">*</span></label>
                        <input 
                            id="email"
                            type="text" 
                            name="email" 
                            placeholder="ejemplo@novabank.com" 
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-4 focus:ring-2 focus:ring-[#02B48A] placeholder-gray-400 outline-none text-sm transition-all"
                        >
                    </div>

                    {{-- Campo Contraseña (Con botón personalizado) --}}
                    <div class="mb-2" x-data="{ show: false }">
                        <label class="block text-gray-300 text-[12px] sm:text-[13px] mb-2" for="password">Contraseña <span class="text-red-400">*</span></label>
                        <div class="relative w-full">
                            <input 
                                id="password"
                                :type="show ? 'text' : 'password'" 
                                name="password" 
                                placeholder="••••••••" 
                                required
                                {{-- Se agregó pr-12 para que el texto no pise el icono --}}
                                class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-4 pr-12 focus:ring-2 focus:ring-[#02B48A] placeholder-gray-400 outline-none text-sm transition-all"
                            >
                            
                            {{-- Botón Ojo Absoluto --}}
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                {{-- Icono Ojo --}}
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{-- Icono Ojo Tachado --}}
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Mensajes de error --}}
                    @if (session('inactivity'))
                        <p class="text-amber-400 text-[12px] text-center mt-1 font-medium">
                            Tu sesión se cerró por inactividad. Inicia sesión de nuevo.
                        </p>
                    @endif

                    @if (session('account_unlocked'))
                        <p class="text-emerald-400 text-[12px] text-center mt-1 font-medium">
                            Tu cuenta ha sido desbloqueada. Ya puedes iniciar sesión.
                        </p>
                    @endif

                    @error('blocked')
                        <p class="text-[#ef4444] text-[12px] text-center mt-1 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('email')
                        <p class="text-[#ef4444] text-[12px] text-center mt-1 font-medium">
                            {{ $message }}
                        </p>
                    @enderror

                    @if (session('remaining_attempts'))
                        <p class="text-amber-400 text-[12px] text-center mt-1 font-medium">
                            Contraseña incorrecta. Te quedan {{ session('remaining_attempts') }} intento{{ session('remaining_attempts') > 1 ? 's' : '' }}.
                        </p>
                    @endif

                    @if (session('invalidUnlockLink'))
                        <p class="text-[#ef4444] text-[12px] text-center mt-1 font-medium">
                            El enlace de desbloqueo no es válido o ya fue utilizado.
                        </p>
                    @endif

                    {{-- Link Recuperar --}}
                    <div class="flex justify-end mb-7 sm:mb-9 md:mb-10 pr-1 sm:pr-2 mt-1">
                        <a href="{{ route('password.request') }}" class="text-[#94A3B8] text-[12px] hover:text-white transition-colors">
                            Recuperar contraseña
                        </a>
                    </div>

                    <button type="submit" class="w-full bg-[#02B48A] hover:bg-[#029A73] text-white font-medium py-3 rounded-full transition duration-200 text-sm active:scale-95 cursor-pointer">
                        Iniciar sesión
                    </button>
                </form>
            </div>

            {{-- Enlace Inferior --}}
            <div class="mt-auto text-center pt-5 sm:pt-6 flex justify-between items-center px-1 sm:px-2 gap-3">
                <span class="text-[#94A3B8] text-[12px]">¿No tienes cuenta?</span>
                <a href="{{ route('register') }}" class="text-white text-[12px] hover:underline transition-colors font-semibold">
                    Registrar cuenta
                </a>
            </div>
        </div>
    </div>
</x-layouts::auth>