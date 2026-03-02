<x-nova>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
    </style>

    {{-- Contenedor principal con fondo azul sólido --}}
    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">
        
        {{-- HEADER: Logo e Inclusión del Componente --}}
        <header class="flex justify-between items-center px-12 py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[200px] h-auto">
            </div>
            
            {{-- Llamada al componente reutilizable --}}
            <x-user-dropdown />
        </header>

        {{-- CONTENIDO CENTRAL --}}
        <main class="flex flex-col items-center justify-center mt-4 px-6 w-full min-h-[60vh]">
            
            <div class="flex flex-col md:flex-row justify-between w-full max-w-5xl mb-24 gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold tracking-[0.1em] uppercase">
                        Ventanilla Asignada: <span class="font-normal opacity-90">{{ $turn->serviceCounter->identifier }}</span>
                    </h2>
                </div>
                <div class="text-center md:text-right">
                    <h2 class="text-2xl md:text-3xl font-bold tracking-[0.1em] uppercase">
                        Turno Generado: <span class="font-normal opacity-90">{{ $turn->turn_number }}</span>
                    </h2>
                </div>
            </div>

            <div class="text-center mb-6">
                <p class="text-lg font-semibold tracking-wide">
                    Tiempo estimado de espera: <span id="etaDisplay" class="font-bold text-blue-200">{{ gmdate('i:s', $etaSeconds ?? 0) }}</span>
                </p>
            </div>

            <div class="flex justify-center mb-20">
                {{-- Botón Cancelar (Rojo) --}}
                <form method="GET" action="{{ route('nova.turno.cancel') }}">
                    <button type="submit" class="bg-[#d3111b] hover:bg-[#b00e16] transition-all duration-200 rounded-[2rem] p-8 w-72 h-44 flex items-center justify-center text-center shadow-xl hover:scale-105 active:scale-95 border border-white/5">
                        <span class="text-2xl font-bold leading-tight text-white">
                            Cancelar <br> Turno
                        </span>
                    </button>
                </form>
            </div>

        </main>
    </div>
    <script>
        setInterval(() => {
            fetch('{{ route('nova.turno.active') }}', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(d => {
                    if (!d.has_turn) {
                        const q = d.last_status === 'expired' ? 'expired=1' : (d.last_status === 'cancelled' ? 'cancelled=1' : '');
                        window.location.href = '{{ route('nova.index') }}' + (q ? ('?' + q) : '');
                        return;
                    }
                    if (d.status === 'expired' || d.status === 'cancelled') {
                        const q = d.status === 'expired' ? 'expired=1' : 'cancelled=1';
                        window.location.href = '{{ route('nova.index') }}?' + q;
                    }
                    if (d.eta_seconds !== undefined) {
                        const mins = Math.max(0, Math.floor(d.eta_seconds / 60));
                        const mm = String(mins).padStart(2, '0');
                        document.getElementById('etaDisplay').textContent = mm + ':00';
                    }
                })
                .catch(() => {});
        }, 3000);
    </script>
</x-nova>
