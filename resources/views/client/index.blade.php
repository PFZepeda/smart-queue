<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
    </style>

    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">
        
        {{-- Header alineado --}}
        <header class="flex justify-between items-center px-12 py-8 w-full">
            <div class="flex items-center">
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[180px] h-auto">
            </div>

            <x-user-dropdown />
        </header>

        <main class="flex flex-col items-center justify-center mt-6 px-6 w-full">

            {{-- Mensajes de estado --}}
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-400 text-red-100 px-6 py-3 rounded-xl mb-6 max-w-2xl w-full text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-400 text-green-100 px-6 py-3 rounded-xl mb-6 max-w-2xl w-full text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(request()->boolean('expired'))
                <div class="bg-red-500/20 border border-red-400 text-red-100 px-6 py-3 rounded-xl mb-6 max-w-2xl w-full text-center">
                    Tu turno ha expirado.
                </div>
            @endif
            @if(request()->boolean('cancelled'))
                <div class="bg-amber-500/20 border border-amber-400 text-amber-100 px-6 py-3 rounded-xl mb-6 max-w-2xl w-full text-center">
                    Tu turno ha sido cancelado.
                </div>
            @endif

            {{-- Si el usuario ya tiene un turno activo, mostrar info --}}
            @php
                $activeTurn = \App\Models\Turn::getUserActiveTurn(auth()->id());
            @endphp

            @if($activeTurn)
                <h1 class="text-[28px] md:text-[36px] font-bold tracking-[0.25em] text-center uppercase mb-10 drop-shadow-md">
                    TU TURNO ACTIVO
                </h1>

                <div class="bg-[#072b4e] rounded-[2.5rem] p-12 w-full max-w-lg text-center shadow-2xl border border-white/10 mb-10">
                    <p class="text-lg mb-4 text-white/80">{{ $activeTurn->serviceCounter->label }}</p>
                    <p class="text-6xl font-bold mb-4 text-[#02B48A]">{{ $activeTurn->turn_number }}</p>
                    <p class="text-lg text-white/70 mb-8">Estado: <span class="font-bold text-white">{{ $activeTurn->status === 'waiting' ? 'En espera' : 'En atención' }}</span></p>
                    
                    <form method="GET" action="{{ route('nova.turno.cancel') }}">
                        <button type="submit" class="bg-[#d3111b] hover:bg-[#b00e16] transition-all duration-200 rounded-[2rem] px-10 py-5 text-xl font-bold text-white shadow-xl hover:scale-105 active:scale-95">
                            Cancelar Turno
                        </button>
                    </form>
                </div>
            @else
                {{-- Título con espaciado amplio igual que el diseño --}}
                <h1 class="text-[28px] md:text-[36px] font-bold tracking-[0.25em] text-center uppercase mb-20 drop-shadow-md">
                    TRÁMITE A REALIZAR
                </h1>

                <div class="flex flex-col md:flex-row gap-12 w-full max-w-5xl justify-center mb-10">
                    {{-- Botón: Acudir a Ventanilla --}}
                    <a href="{{ route('nova.ventanilla.tramite') }}" 
                       class="bg-[#02B48A] hover:bg-[#029672] transition-all hover:scale-105 duration-300 rounded-[2.5rem] p-10 w-full md:w-[320px] h-56 flex items-center justify-center text-center shadow-2xl border border-white/10 group">
                        <span class="text-2xl font-bold leading-tight text-white group-hover:drop-shadow-lg">Acudir a <br> ventanilla</span>
                    </a>

                    {{-- Botón: Hablar con Asesor --}}
                    <a href="{{ route('nova.asesor.generar') }}" 
                       class="bg-[#02B48A] hover:bg-[#029672] transition-all hover:scale-105 duration-300 rounded-[2.5rem] p-10 w-full md:w-[320px] h-56 flex items-center justify-center text-center shadow-2xl border border-white/10 group">
                        <span class="text-2xl font-bold leading-tight text-white group-hover:drop-shadow-lg">Hablar con <br> un Asesor</span>
                    </a>
                </div>
            @endif
        </main>
    </div>
</x-nova>
