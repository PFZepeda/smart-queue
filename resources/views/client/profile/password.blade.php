<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap');
        input::-ms-reveal, input::-ms-clear { display: none; }
        input[type="password"]::-webkit-reveal,
        input[type="password"]::-webkit-clear-button { display: none !important; }
    </style>

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">

        {{-- HEADER --}}
        <header class="flex justify-between items-center px-4 sm:px-8 md:px-12 py-5 sm:py-6 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[140px] sm:w-[165px] md:w-[180px] h-auto">
            </div>

            <x-user-dropdown />
        </header>

        <main class="flex items-center justify-center px-4 sm:px-6 min-h-[75vh] pb-24 sm:pb-16">

            {{-- TARJETA --}}
            <div
                class="bg-[#072b4e] rounded-3xl px-10 py-10 w-full max-w-3xl
                    shadow-xl flex flex-col lg:flex-row items-start lg:items-center gap-7 sm:gap-10 border border-white/5 px-5 sm:px-8 md:px-10 py-6 sm:py-8 md:py-10">

                <div class="flex-1">

                    <h2 class="text-[1.7rem] sm:text-3xl font-bold mb-1">Cambiar contraseña</h2>
                    <p class="text-gray-300 mb-6 sm:mb-8 text-[13px] sm:text-sm">
                        Aquí puedes actualizar tu contraseña para mantener tu cuenta segura. Asegúrate de elegir una contraseña fuerte y única.
                    </p>

                    {{-- Mensaje de éxito --}}
                    @if (session('status') === 'password-updated')
                        <div class="mb-4 flex items-center gap-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            ¡Tu contraseña fue actualizada correctamente!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-4 sm:space-y-5">
                        @csrf

                        {{-- Contraseña actual --}}
                        <div x-data="{ show: false }">
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Contraseña actual <span class="text-red-500">*</span>
                            </label>
                            <div class="relative w-full">
                                <input :type="show ? 'text' : 'password'" name="current_password"
                                    placeholder="Introduce tu contraseña"
                                     class="w-full bg-[#4D647C] rounded-xl py-2.5 sm:py-3 px-4 sm:px-5 pr-12
                                           text-white placeholder-gray-400
                                           focus:outline-none focus:ring-2 focus:ring-[#007A7C]
                                           transition-all text-sm
                                           {{ $errors->has('current_password') ? 'ring-2 ring-red-400' : '' }}">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Nueva contraseña --}}
                        <div x-data="{ show: false }">
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Nueva contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative w-full">
                                <input :type="show ? 'text' : 'password'" name="password"
                                    placeholder="Introduce tu nueva contraseña"
                                     class="w-full bg-[#4D647C] rounded-xl py-2.5 sm:py-3 px-4 sm:px-5 pr-12
                                           text-white placeholder-gray-400
                                           focus:outline-none focus:ring-2 focus:ring-[#007A7C]
                                           transition-all text-sm
                                           {{ $errors->has('password') ? 'ring-2 ring-red-400' : '' }}">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1.5 text-[11px] text-gray-400">Mínimo 8 caracteres, debe incluir letras y números.</p>
                            @error('password')
                                <p class="mt-1.5 flex items-center gap-1.5 text-xs text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div x-data="{ show: false }">
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Confirmar contraseña <span class="text-red-500">*</span>
                            </label>
                            <div class="relative w-full">
                                <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                    placeholder="Confirma tu contraseña"
                                     class="w-full bg-[#4D647C] rounded-xl py-2.5 sm:py-3 px-4 sm:px-5 pr-12
                                           text-white placeholder-gray-400
                                           focus:outline-none focus:ring-2 focus:ring-[#007A7C]
                                           transition-all text-sm">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#007A7C] hover:bg-[#005f61]
                                   text-white font-semibold py-3
                                   rounded-xl text-sm sm:text-base
                                   shadow-md transition-all active:scale-[0.98]">
                            Guardar cambios
                        </button>
                    </form>
                </div>

                {{-- Logo lateral --}}
                <div class="hidden lg:flex flex-col items-center">
                    <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[220px] opacity-70">
                </div>

            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="fixed bottom-4 inset-x-4 sm:inset-x-auto sm:bottom-8 sm:right-10 md:bottom-10 md:right-12">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isOperador() ? route('advisor.dashboard') : route('nova.index')) }}"
                    class="bg-[#02B48A] hover:bg-[#019875]
                           text-white font-semibold py-3 px-8
                           rounded-xl text-sm
                           shadow-lg transition-all active:scale-95 block text-center">
                    Regresar
                </a>
            </div>

        </main>
    </div>
</x-nova>
