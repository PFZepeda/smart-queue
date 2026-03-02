<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap');
    </style>

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">

        {{-- HEADER --}}
        <header class="flex justify-between items-center px-12 py-6 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[180px] h-auto">
            </div>

            <x-user-dropdown />
        </header>

        <main class="flex items-center justify-center px-6 min-h-[75vh]">

            {{-- TARJETA --}}
            <div
                class="bg-[#072b4e] rounded-3xl px-10 py-10 w-full max-w-3xl
                        shadow-xl flex items-center gap-10 border border-white/5">

                <div class="flex-1">

                    <h2 class="text-3xl font-bold mb-1">Cambiar contraseña</h2>
                    <p class="text-gray-300 mb-8 text-sm">
                        Aquí puedes actualizar tu contraseña
                    </p>

                    <form class="space-y-5">

                        <div>
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Contraseña actual
                            </label>
                            <input type="password" placeholder="Introduce tu contraseña"
                                class="w-full bg-[#4D647C] rounded-xl py-3 px-5
                                       text-white placeholder-gray-400
                                       focus:ring-2 focus:ring-[#007A7C]
                                       transition-all text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Nueva contraseña
                            </label>
                            <input type="password" placeholder="Introduce tu nueva contraseña"
                                class="w-full bg-[#4D647C] rounded-xl py-3 px-5
                                       text-white placeholder-gray-400
                                       focus:ring-2 focus:ring-[#007A7C]
                                       transition-all text-sm">
                        </div>

                        <div>
                            <label class="block text-[11px] mb-2 font-semibold uppercase tracking-wider text-gray-300">
                                Confirmar contraseña
                            </label>
                            <input type="password" placeholder="Confirma tu contraseña"
                                class="w-full bg-[#4D647C] rounded-xl py-3 px-5
                                       text-white placeholder-gray-400
                                       focus:ring-2 focus:ring-[#007A7C]
                                       transition-all text-sm">
                        </div>

                        <button type="submit"
                            class="w-full bg-[#007A7C] hover:bg-[#005f61]
                                   text-white font-semibold py-3
                                   rounded-xl text-base
                                   shadow-md transition-all active:scale-[0.98]">
                            Guardar cambios
                        </button>
                    </form>
                </div>

                {{-- Logo lateral --}}
                <div class="hidden md:flex flex-col items-center">
                    <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[220px] opacity-70">
                </div>

            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="fixed bottom-10 right-12">
                <a href="{{ route('nova.index') }}"
                    class="bg-[#02B48A] hover:bg-[#019875]
                           text-white font-semibold py-3 px-8
                           rounded-xl text-sm
                           shadow-lg transition-all active:scale-95">
                    Regresar
                </a>
            </div>

        </main>
    </div>
</x-nova>
