<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap');
    </style>

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">

        {{-- HEADER --}}
        <header class="flex justify-between items-center px-12 py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[190px] h-auto">
            </div>

            <x-user-dropdown />
        </header>

        {{-- CONTENIDO --}}
        <main class="flex items-center justify-center px-6 min-h-[75vh]">

            {{-- TARJETA --}}
            <div class="bg-[#072b4e] rounded-[2rem] p-14 w-full max-w-3xl shadow-2xl border border-white/5">

                <div class="text-center">
                    <h2 class="text-3xl font-bold text-red-500 mb-4 tracking-wide">
                        PRECAUCIÓN !!
                    </h2>

                    <p class="text-gray-300 text-base mb-10">
                        Antes de eliminar tu cuenta, necesitamos confirmar que eres tú.
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.confirm-delete.verify') }}" class="space-y-8">
                    @csrf

                    <div>
                        <label class="block text-sm mb-3 font-semibold uppercase tracking-wider">
                            Introduce tu contraseña <span class="text-red-500">*</span>
                        </label>

                        <input type="password" name="password" placeholder="Introduce tu contraseña"
                            class="w-full bg-[#4D647C] rounded-2xl py-4 px-6 text-white placeholder-gray-300 outline-none focus:ring-2 focus:ring-[#007A7C] transition @error('password') ring-2 ring-red-500 @enderror">

                        @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#007A7C] hover:bg-[#005f61] transition-colors text-white font-bold py-4 rounded-2xl text-lg shadow-lg active:scale-[0.98]">
                        Confirmar contraseña
                    </button>

                </form>
            </div>

            {{-- BOTÓN REGRESAR --}}
            <div class="fixed bottom-12 right-14">
                <a href="{{ route('nova.index') }}"
                    class="bg-[#02B48A] hover:bg-[#019875]
                           text-white font-bold py-4 px-10
                           rounded-2xl text-base
                           shadow-2xl transition-all active:scale-95">
                    Regresar
                </a>
            </div>

        </main>
    </div>
</x-nova>
