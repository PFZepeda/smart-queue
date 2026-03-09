<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap');
    </style>

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">

        {{-- HEADER --}}
        <header class="flex justify-between items-center px-4 sm:px-8 md:px-12 py-5 sm:py-7 md:py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[140px] sm:w-[170px] md:w-[190px] h-auto">
            </div>

            <x-user-dropdown />
        </header>

        {{-- CONTENIDO --}}
        <main class="flex items-center justify-center px-4 sm:px-6 min-h-[75vh] pb-24 sm:pb-16">

            {{-- TARJETA --}}
            <div class="bg-[#072b4e] rounded-[1.4rem] sm:rounded-[2rem] p-6 sm:p-10 md:p-14 w-full max-w-3xl shadow-2xl border border-white/5">

                <div class="text-center">
                    <h2 class="text-[1.7rem] sm:text-3xl font-bold text-red-500 mb-3 sm:mb-4 tracking-wide">
                        PRECAUCIÓN !!
                    </h2>

                    <p class="text-gray-300 text-sm sm:text-base mb-7 sm:mb-10">
                        Antes de eliminar tu cuenta, necesitamos confirmar que eres tú.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.confirm-delete.verify') }}" class="space-y-6 sm:space-y-8">
                    @csrf

                    <div x-data="{ show: false }">
                        <label class="block text-[12px] sm:text-sm mb-2.5 sm:mb-3 font-semibold uppercase tracking-wider">
                            Introduce tu contraseña <span class="text-red-500">*</span>
                        </label>

                        <div class="relative w-full">
                            <input :type="show ? 'text' : 'password'" name="password" placeholder="Introduce tu contraseña"
                                class="w-full bg-[#4D647C] rounded-xl sm:rounded-2xl py-3 sm:py-4 px-5 sm:px-6 pr-12 text-white placeholder-gray-300 outline-none focus:ring-2 focus:ring-[#007A7C] transition @error('password') ring-2 ring-red-500 @enderror">

                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-300 hover:text-white focus:outline-none" aria-label="Mostrar u ocultar contraseña">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#007A7C] hover:bg-[#005f61] transition-colors text-white font-bold py-3 sm:py-4 rounded-xl sm:rounded-2xl text-base sm:text-lg shadow-lg active:scale-[0.98]">
                        Confirmar contraseña
                    </button>

                </form>
            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="fixed bottom-4 inset-x-4 sm:inset-x-auto sm:bottom-10 sm:right-10 md:bottom-12 md:right-14">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isOperador() ? route('advisor.dashboard') : route('nova.index')) }}"
                    class="bg-[#02B48A] hover:bg-[#019875]
                           text-white font-bold py-3 sm:py-4 px-8 sm:px-10
                           rounded-xl sm:rounded-2xl text-sm sm:text-base
                           shadow-2xl transition-all active:scale-95 block text-center">
                    Regresar
                </a>
            </div>

        </main>
    </div>
</x-nova>
