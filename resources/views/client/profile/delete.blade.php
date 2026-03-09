<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
    </style>

    {{-- Fondo de la página: Azul #0C4D8B --}}
    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">

        {{-- HEADER UNIFICADO CON COMPONENTE --}}
        <header class="flex justify-between items-center px-4 sm:px-8 md:px-12 py-5 sm:py-7 md:py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[145px] sm:w-[175px] md:w-[200px] h-auto">
            </div>

            {{-- Inclusión del componente modular --}}
            <x-user-dropdown />
        </header>

        <main class="flex flex-col items-center justify-center px-4 sm:px-6 min-h-[70vh] py-4 sm:py-0">
            {{-- LA TARJETA: Color oficial #072b4e --}}
            <div class="bg-[#072b4e] rounded-[1.6rem] sm:rounded-[2.5rem] p-6 sm:p-9 md:p-12 w-full max-w-2xl shadow-2xl flex flex-col items-center border border-white/5">
                
                <h2 class="text-[1.6rem] sm:text-3xl font-bold text-red-600 mb-2 tracking-wider uppercase text-center drop-shadow-sm">PRECAUCIÓN !!</h2>
                <p class="text-white text-[13px] sm:text-sm mb-6 sm:mb-8 text-center font-normal opacity-90">¿Estás seguro de eliminar tu cuenta?</p>

                {{-- Caja de Texto Informativa --}}
                <div class="bg-[#4D647C] rounded-[1.1rem] sm:rounded-[1.5rem] w-full min-h-[220px] sm:min-h-[280px] px-5 sm:px-9 md:px-12 py-6 sm:py-8 md:py-10 text-white text-[15px] sm:text-lg mb-7 sm:mb-10 shadow-inner flex flex-col justify-center leading-relaxed border border-white/5">
                    <p class="mb-3 sm:mb-4 font-semibold">Una vez eliminada tu cuenta, esta acción no se puede deshacer.</p>
                    <div class="space-y-2 opacity-90">
                        <p class="flex items-start">
                            <span class="inline-block mr-3 text-red-400 font-bold">•</span>
                            <span>Todos tus datos personales serán eliminados permanentemente.</span>
                        </p>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="w-full space-y-3 sm:space-y-4 px-0 sm:px-6">
                    {{-- Botón Eliminar --}}
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="w-full bg-[#B21321] hover:bg-[#900f1a] text-white font-bold py-3 sm:py-4 rounded-xl sm:rounded-2xl text-base sm:text-lg shadow-lg transition-all active:scale-[0.98]">
                            Eliminar Cuenta
                        </button>
                    </form>
                    
                    {{-- Botón Regresar --}}
                    <a href="{{ route('profile.edit') }}" class="block w-full bg-[#02B48A] hover:bg-[#019875] text-white font-bold py-3 sm:py-4 rounded-xl sm:rounded-2xl text-base sm:text-lg shadow-lg transition-all text-center active:scale-[0.98]">
                        Regresar
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-nova>