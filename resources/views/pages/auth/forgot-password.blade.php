<x-layouts::auth>
    {{-- Tipo grafia requerida para el diseño de la página de recuperación de contraseña. Se importan las fuentes 'Roboto' y 'Source Sans 3'  --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');

        @media (max-height: 740px) {
            .forgot-wrapper {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="forgot-wrapper fixed inset-0 flex flex-col items-center justify-center bg-[#0C4D8B] z-50 font-['Source_Sans_3'] overflow-y-auto px-4 py-6 sm:px-6 sm:py-8">
        
        {{-- SECCIÓN DEL LOGO ACTUALIZADA --}}
        <div class="mb-6 sm:mb-8 md:mb-10 text-center flex flex-col items-center">
            <img 
                src="{{ asset('images/Logo_1.svg') }}" 
                alt="Logo NovaBank" 
                class="w-[165px] sm:w-[195px] md:w-[220px] h-auto object-contain"
            >
        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div class="w-full max-w-[440px] min-h-[500px] sm:min-h-[540px] max-h-[calc(100vh-3rem)] sm:max-h-[calc(100vh-4rem)] flex flex-col justify-between overflow-y-auto bg-[#072b4e] px-6 sm:px-8 md:px-10 py-8 sm:py-10 md:py-12 rounded-[1.3rem] sm:rounded-[1.5rem] shadow-2xl"
             x-data="{
                 cooldown: 0,
                 sent: {{ session('status') ? 'true' : 'false' }},
                 init() {
                     if (this.sent) {
                         this.cooldown = 30;
                         this.startTimer();
                     }
                 },
                 startTimer() {
                     const interval = setInterval(() => {
                         this.cooldown--;
                         if (this.cooldown <= 0) {
                             this.cooldown = 0;
                             clearInterval(interval);
                         }
                     }, 1000);
                 }
             }">
            
            {{-- Grupo Superior: Título y Formulario --}}
            <div class="w-full">
                <h2 class="font-['Roboto'] text-white text-center text-[1.05rem] sm:text-[1.1rem] md:text-[1.15rem] font-normal mb-6 sm:mb-8 tracking-wide">
                    Recuperar contraseña
                </h2>

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col"
                      @submit="if (cooldown > 0) { $event.preventDefault(); return; }">
                    @csrf
                    
                    <div class="mb-5 sm:mb-6">
                        <label class="block text-center text-gray-300 text-[12px] sm:text-[13px] mb-3">Email para recuperación</label>
                        
                        <input 
                            type="email" 
                            name="email"
                            placeholder="ejemplo@gmail.com"
                            value="{{ session('status') ? '' : old('email') }}"
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-lg py-2.5 sm:py-3 px-4 focus:ring-2 focus:ring-[#02B48A] placeholder-gray-400 outline-none text-sm transition-all"
                            required
                            autofocus
                        >
                        
                        @error('email')
                            <span class="text-[#ef4444] text-[12px] mt-2 block font-medium">Correo no registrado</span>
                        @enderror

                        @if (session('status'))
                            <span class="text-[#4ade80] text-[12px] mt-2 block font-medium text-center">
                                Correo de recuperación enviado
                            </span>
                        @endif
                    </div>

                    {{-- Contador de cooldown --}}
                    <template x-if="cooldown > 0">
                        <p class="text-amber-400 text-[12px] text-center mb-3 font-medium">
                            Podrás enviar otro correo en <span x-text="cooldown"></span> segundos
                        </p>
                    </template>

                    <button type="submit" 
                        :disabled="cooldown > 0"
                        :class="cooldown > 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#029A73]'"
                        class="w-full bg-[#02B48A] text-white font-medium py-3 rounded-lg transition duration-200 text-sm mt-1 cursor-pointer">
                        <span x-text="cooldown > 0 ? 'Espera ' + cooldown + 's' : 'Enviar'"></span>
                    </button>
                </form>
            </div>

            {{-- Grupo Inferior: Enlace anclado al fondo --}}
            <div class="mt-auto text-center pt-5 sm:pt-6">
                <flux:link href="{{ route('login') }}" class="text-[#94A3B8] text-[12px] hover:text-white transition-colors decoration-none">
                    Regresar a inicio de sesión
                </flux:link>
            </div>
        </div>
    </div>
</x-layouts::auth>