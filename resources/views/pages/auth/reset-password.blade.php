<x-layouts::auth>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');

        @media (max-height: 740px) {
            .reset-wrapper {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="reset-wrapper fixed inset-0 flex flex-col items-center justify-center bg-[#0C4D8B] z-50 font-['Source_Sans_3'] overflow-y-auto px-4 py-6 sm:px-6 sm:py-8">
        
        {{-- LOGO --}}
        <div class="mb-6 sm:mb-8 md:mb-10 text-center flex flex-col items-center">
            <img 
                src="{{ asset('images/Logo_1.svg') }}" 
                alt="Logo NovaBank" 
                class="w-[165px] sm:w-[195px] md:w-[220px] h-auto object-contain"
            >
        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div class="w-full max-w-[440px] min-h-[500px] sm:min-h-[540px] max-h-[calc(100vh-3rem)] sm:max-h-[calc(100vh-4rem)] flex flex-col justify-between overflow-y-auto bg-[#072b4e] px-6 sm:px-8 md:px-10 py-8 sm:py-10 md:py-12 rounded-[1.3rem] sm:rounded-[1.5rem] shadow-2xl">
            
            <div class="w-full">
                <h2 class="text-white text-center text-[1.05rem] sm:text-[1.1rem] md:text-[1.15rem] font-normal mb-6 sm:mb-8 tracking-wide">
                    Nueva contraseña
                </h2>

                <form method="POST" action="{{ route('password.update') }}" class="flex flex-col">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ $request->email }}">
                    
                    {{-- Nueva Contraseña --}}
                    <div class="mb-4 sm:mb-5">
                        <label class="block text-gray-300 text-[12px] sm:text-[13px] mb-2" for="password">Ingresa nueva contraseña</label>
                        <input 
                            id="password"
                            type="password" 
                            name="password"
                            placeholder="8-10 caracteres, letras y números"
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-4 focus:ring-2 focus:ring-[#02B48A] placeholder-gray-400 outline-none text-sm transition-all"
                        >
                        
                        @error('password')
                            <span class="text-[#ef4444] text-[12px] mt-2 block font-medium">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div class="mb-5 sm:mb-6">
                        <label class="block text-gray-300 text-[12px] sm:text-[13px] mb-2" for="password_confirmation">Confirmar contraseña</label>
                        <input 
                            id="password_confirmation"
                            type="password" 
                            name="password_confirmation"
                            placeholder="8-10 caracteres, letras y números"
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-4 focus:ring-2 focus:ring-[#02B48A] placeholder-gray-400 outline-none text-sm transition-all"
                        >
                    </div>

                    {{-- Botón Restablecer --}}
                    <button type="submit" class="w-full bg-[#02B48A] hover:bg-[#029A73] text-white font-medium py-3 rounded-full transition duration-200 text-sm">
                        Restablecer contraseña
                    </button>
                </form>
            </div>

            {{-- Enlace Inferior --}}
            <div class="mt-auto text-center pt-5 sm:pt-6">
                <flux:link href="{{ route('login') }}" class="text-[#94A3B8] text-[12px] hover:text-white transition-colors decoration-none">
                    Regresar a inicio de sesión
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts::auth>