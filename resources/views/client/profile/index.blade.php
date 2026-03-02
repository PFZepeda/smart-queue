<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap');
    </style>

    <div
        class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50 flex flex-col">

        {{-- HEADER --}}
        <header class="flex justify-between items-center px-14 py-8 w-full shrink-0">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[200px] h-auto">
            </div>
            <x-user-dropdown />
        </header>

        <main class="flex-grow flex items-center justify-center px-8 pb-24 relative">

            {{-- TARJETA --}}
            <div
                class="bg-[#072b4e] rounded-[2.5rem] px-14 py-14 w-full max-w-4xl
                       shadow-2xl flex flex-col md:flex-row items-center gap-14
                       border border-white/5">

                {{-- CONTENIDO --}}
                <div class="flex-1 w-full space-y-8">

                    <div class="space-y-2">
                        <h2 class="text-4xl font-bold">Perfil</h2>
                        <p class="text-gray-300 text-base">
                            Información registrada en el sistema
                        </p>
                    </div>

                    {{-- Nombre --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium">
                            Nombre Completo
                        </label>

                        <input type="text" value="{{ old('name', auth()->user()->name) }}" readonly
                            class="w-full bg-[#4D647C]
                                   rounded-xl py-4 px-6 text-white
                                   border border-white/10
                                   focus:ring-2 focus:ring-[#02B48A]
                                   transition-all
                                   opacity-90 cursor-not-allowed">
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-medium">
                            Correo electrónico
                        </label>

                        <input type="email" value="{{ old('email', auth()->user()->email) }}" readonly
                            class="w-full bg-[#4D647C]
                                   rounded-xl py-4 px-6 text-white
                                   border border-white/10
                                   focus:ring-2 focus:ring-[#02B48A]
                                   transition-all
                                   opacity-90 cursor-not-allowed">
                    </div>

                    {{-- Botón eliminar --}}
                    <div class="pt-4">
                        <a href="{{ route('profile.confirm-delete') }}"
                            class="inline-block bg-[#B21321] hover:bg-[#900f1a]
                                   text-white text-sm font-semibold
                                   py-3 px-8 rounded-full
                                   transition-all shadow-md active:scale-95">
                            Eliminar Cuenta
                        </a>
                    </div>
                </div>

                {{-- Logo lateral --}}
                <div class="hidden md:flex flex-col items-center flex-1">
                    <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank"
                        class="w-[300px] opacity-85 select-none pointer-events-none">
                </div>
            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="fixed bottom-12 right-14">
                <a href="{{ route('nova.index') }}"
                    class="bg-[#02B48A] hover:bg-[#019875]
                           text-white font-bold py-4 px-10
                           rounded-2xl text-lg
                           shadow-2xl transition-all active:scale-95">
                    Regresar
                </a>
            </div>

        </main>
    </div>
</x-nova>
