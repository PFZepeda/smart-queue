<x-layouts::auth>
    <style>
        /* Importación corregida con ambas tipografías */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
    </style>

    {{-- Contenedor principal ajustado al 100% de la pantalla con scroll libre --}}
    <div class="fixed inset-0 w-full h-full overflow-y-auto bg-[#0C4D8B] font-['Source_Sans_3'] text-white z-50">
        
        {{-- HEADER: Logo a la izquierda, Icono de Usuario a la derecha --}}
        <header class="flex justify-between items-center px-12 py-8 w-full">
            <div>
                <img src="{{ asset('images/Logo_1.svg') }}" alt="NovaBank" class="w-[200px] h-auto">
            </div>
            
            {{-- Icono de Usuario Circular con Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="w-[50px] h-[50px] bg-[#3B82F6] rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-blue-600 transition-colors focus:outline-none">
                    <svg class="w-8 h-8 text-white mt-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-3 w-48 bg-[#072b4e] rounded-xl shadow-2xl border border-white/10 overflow-hidden z-50" style="display: none;">
                    
                    {{-- Nombre del usuario --}}
                    <div class="px-4 py-3 border-b border-white/10">
                        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-gray-400 text-xs truncate">{{ auth()->user()->email }}</p>
                    </div>

                    {{-- Cerrar sesión --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-white hover:bg-white/10 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- CONTENIDO CENTRAL --}}
        <main class="flex flex-col items-center mt-4 px-6 w-full" x-data="{
            showAreaModal: false,
            areaId: null,
            areaLabel: '',
            areaOperador: '',
            areaTurnos: 0,
            areaActive: true,
            openArea(id, label, operador, turnos, active) {
                this.areaId = id;
                this.areaLabel = label;
                this.areaOperador = operador;
                this.areaTurnos = turnos;
                this.areaActive = active;
                this.showAreaModal = true;
            }
        }">
            
            {{-- Título Principal --}}
            <h1 class="text-[26px] font-bold tracking-wider uppercase mb-12 text-center w-full">
                Panel Administrador
            </h1>

            {{-- Grid de Ventanillas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-[1000px] mb-12">
                @if($ventanillas->count() > 0)
                    @foreach($ventanillas as $ventanilla)
                        @php
                            $operador = \App\Models\User::where('area_designada', $ventanilla->label)->first();
                            $turnosTotales = $ventanilla->turns()->count();
                        @endphp
                        <div @click="openArea({{ $ventanilla->id }}, '{{ $ventanilla->label }}', '{{ $operador ? $operador->name : 'Sin asignar' }}', {{ $turnosTotales }}, {{ $ventanilla->is_active ? 'true' : 'false' }})"
                             class="rounded-[1.5rem] p-8 flex flex-col items-center justify-center min-h-[170px] shadow-lg border border-white/5 cursor-pointer transition-all hover:scale-[1.03] hover:shadow-2xl {{ $ventanilla->is_active ? 'bg-[#02B48A]' : 'bg-gray-500/70' }}">
                            <h2 class="font-bold text-[18px] mb-2 text-white">{{ $ventanilla->label }}</h2>
                            <p class="text-[15px] mb-6 text-white/90">Operador:
                                <span class="font-bold">{{ $operador ? $operador->name : 'Sin asignar' }}</span>
                            </p>
                            <p class="text-[15px] text-white/90">Turnos totales: <span class="font-bold">{{ $turnosTotales }}</span></p>
                            @if(!$ventanilla->is_active)
                                <span class="mt-2 text-[13px] bg-red-600/80 px-3 py-1 rounded-full font-semibold">Deshabilitada</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-[#02B48A] rounded-[1.5rem] p-8 flex flex-col items-center justify-center min-h-[170px] shadow-lg border border-white/5">
                            <h2 class="font-bold text-[18px] mb-2 text-white">Ventanilla {{ $i }}</h2>
                            <p class="text-[15px] mb-6 text-white/90">Operador:</p>
                            <p class="text-[15px] text-white/90">Turnos totales:</p>
                        </div>
                    @endfor
                @endif
            </div>

            {{-- Grid de Asesores --}}
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;" class="w-full max-w-[1000px] mb-12">
                @if($asesores->count() > 0)
                    @foreach($asesores as $asesor)
                        @php
                            $operador = \App\Models\User::where('area_designada', $asesor->label)->first();
                            $turnosTotales = $asesor->turns()->count();
                        @endphp
                        <div @click="openArea({{ $asesor->id }}, '{{ $asesor->label }}', '{{ $operador ? $operador->name : 'Sin asignar' }}', {{ $turnosTotales }}, {{ $asesor->is_active ? 'true' : 'false' }})"
                             class="rounded-[1.5rem] p-8 flex flex-col items-center justify-center min-h-[170px] shadow-lg border border-white/5 cursor-pointer transition-all hover:scale-[1.03] hover:shadow-2xl {{ $asesor->is_active ? 'bg-[#02B48A]' : 'bg-gray-500/70' }}">
                            <h2 class="font-bold text-[18px] mb-2 text-white">{{ $asesor->label }}</h2>
                            <p class="text-[15px] mb-6 text-white/90">Operador:
                                <span class="font-bold">{{ $operador ? $operador->name : 'Sin asignar' }}</span>
                            </p>
                            <p class="text-[15px] text-white/90">Turnos totales: <span class="font-bold">{{ $turnosTotales }}</span></p>
                            @if(!$asesor->is_active)
                                <span class="mt-2 text-[13px] bg-red-600/80 px-3 py-1 rounded-full font-semibold">Deshabilitada</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="bg-[#02B48A] rounded-[1.5rem] p-8 flex flex-col items-center justify-center min-h-[170px] shadow-lg border border-white/5">
                            <h2 class="font-bold text-[18px] mb-2 text-white">Asesor {{ $i }}</h2>
                            <p class="text-[15px] mb-6 text-white/90">Operador:</p>
                            <p class="text-[15px] text-white/90">Turnos totales:</p>
                        </div>
                    @endfor
                @endif
            </div>

            {{-- Modal de Área --}}
            <template x-teleport="body">
                <div x-show="showAreaModal"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-[9999] flex items-center justify-center"
                     style="display: none;"
                     @keydown.escape.window="showAreaModal = false">

                    {{-- Fondo con blur --}}
                    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showAreaModal = false"></div>

                    {{-- Contenido del Modal --}}
                    <div x-show="showAreaModal"
                         x-transition:enter="transition ease-out duration-200 delay-75"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90"
                         class="relative bg-[#02B48A] border border-white/15 rounded-3xl shadow-2xl p-10 max-w-md w-full mx-4 text-center font-['Source_Sans_3']">

                        {{-- Info del Área --}}
                        <h2 class="text-white text-[22px] font-bold mb-3" x-text="areaLabel"></h2>
                        <p class="text-white/90 text-[16px] mb-1">Operador: <span class="font-bold" x-text="areaOperador"></span></p>
                        <p class="text-white/90 text-[16px] mb-8">Turnos totales: <span class="font-bold" x-text="areaTurnos"></span></p>

                        {{-- Botón Deshabilitar / Habilitar --}}
                        <form x-ref="areaForm" method="POST" :action="areaActive ? '/admin/area/' + areaId + '/disable' : '/admin/area/' + areaId + '/enable'">
                            @csrf
                            <template x-if="areaActive">
                                <button type="submit"
                                        class="bg-[#CC0000] hover:bg-[#A30000] text-white px-8 py-4 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl min-w-[220px]">
                                    Deshabilitar Área
                                </button>
                            </template>
                            <template x-if="!areaActive">
                                <button type="submit"
                                        class="bg-[#02854d] hover:bg-[#026e3f] text-white px-8 py-4 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl min-w-[220px]">
                                    Habilitar Área
                                </button>
                            </template>
                        </form>

                        {{-- Botón Cerrar --}}
                        <button type="button"
                                @click="showAreaModal = false"
                                class="mt-4 text-white/70 hover:text-white text-[14px] underline transition-colors">
                            Cerrar
                        </button>
                    </div>
                </div>
            </template>

            {{-- Botones de Acción --}}
            <div class="flex flex-col md:flex-row gap-8 w-full max-w-[800px] justify-center mb-24" x-data="{ showConfirm: false }">
                
                {{-- Botón Encender/Apagar Generación de Turnos --}}
                <form method="POST" action="{{ route('admin.turns.toggle') }}" x-ref="toggleForm">
                    @csrf
                    @if($isActive)
                        <button type="button" class="bg-[#CC0000] hover:bg-[#A30000] text-white px-10 py-5 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl text-center leading-tight min-w-[280px]"
                                @click="showConfirm = true">
                            Apagar Generación <br> de Turnos
                        </button>
                    @else
                            <button type="submit" class="bg-[#02B48A] hover:bg-[#029A73] text-white px-10 py-5 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl flex items-center justify-center min-w-[280px] text-center">
                            Encender Generación <br> de Turnos
                        </button>
                    @endif
                </form>

                {{-- Modal de Confirmación --}}
                <template x-teleport="body">
                    <div x-show="showConfirm"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-[9999] flex items-center justify-center"
                         style="display: none;"
                         @keydown.escape.window="showConfirm = false">

                        {{-- Fondo con blur --}}
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showConfirm = false"></div>

                        {{-- Contenido del Modal --}}
                        <div x-show="showConfirm"
                             x-transition:enter="transition ease-out duration-200 delay-75"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-90"
                             class="relative bg-[#0C4D8B] border border-white/15 rounded-3xl shadow-2xl p-10 max-w-md w-full mx-4 text-center font-['Source_Sans_3']">

                            {{-- Ícono de advertencia --}}
                            <div class="flex justify-center mb-5">
                                <div class="w-16 h-16 bg-[#CC0000] rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Texto --}}
                            <h2 class="text-white text-[22px] font-bold mb-3">¿Estás seguro?</h2>
                            <p class="text-white/80 text-[16px] leading-relaxed mb-8">
                                Esto cancelará todos los turnos activos y reseteará los contadores.
                            </p>

                            {{-- Botones --}}
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <button type="button"
                                        @click="showConfirm = false"
                                        class="bg-[#02B48A] hover:bg-[#029A73] text-white px-8 py-3 rounded-2xl font-bold text-[16px] transition-all active:scale-95 shadow-xl min-w-[140px]">
                                    Cancelar
                                </button>
                                <button type="button"
                                        @click="$refs.toggleForm.submit()"
                                        class="bg-[#CC0000] hover:bg-[#A30000] text-white px-8 py-3 rounded-2xl font-bold text-[16px] transition-all active:scale-95 shadow-xl min-w-[140px]">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                
                {{-- Botón Dar Alta --}}
                <a href="/admin/registro-empleado" class="bg-[#02B48A] hover:bg-[#029A73] text-white px-10 py-5 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl flex items-center justify-center min-w-[280px] text-center">
                    Gestionar <br> Empleados
                </a>
            </div>

            {{-- Título Analíticas --}}
            <h1 class="text-[26px] font-bold tracking-wider uppercase mb-12 text-center w-full">
                Analíticas
            </h1>

            {{-- Grid de estadísticas principales --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 w-full max-w-[1000px] mb-12 text-center">
                <div>
                    <h3 class="text-[16px] font-bold leading-tight mb-3">Total de turnos<br>Generados:</h3>
                    <p class="text-[28px] font-bold">{{ $totalGenerados }}</p>
                </div>
                <div>
                    <h3 class="text-[16px] font-bold leading-tight mb-3">Total de turnos<br>Expirados:</h3>
                    <p class="text-[28px] font-bold">{{ $totalExpirados }}</p>
                </div>
                <div>
                    <h3 class="text-[16px] font-bold leading-tight mb-3">Total de turnos<br>Cancelados:</h3>
                    <p class="text-[28px] font-bold">{{ $totalCancelados }}</p>
                </div>
                <div>
                    <h3 class="text-[16px] font-bold leading-tight mb-3">Total de turnos<br>Finalizados:</h3>
                    <p class="text-[28px] font-bold">{{ $totalFinalizados }}</p>
                </div>
            </div>

            {{-- Promedio y botón de reporte --}}
            <div class="flex flex-col md:flex-row items-center justify-center gap-12 w-full max-w-[1000px] mb-24">
                <div class="text-center">
                    <h3 class="text-[16px] font-bold leading-tight mb-3">Promedio de<br>personas atendidas<br>con éxito:</h3>
                    <p class="text-[28px] font-bold">{{ $promedioExito }}%</p>
                </div>
                <a href="{{ route('admin.report.export') }}"
                   class="bg-[#02B48A] hover:bg-[#029A73] text-white px-10 py-5 rounded-2xl font-bold text-[18px] transition-all active:scale-95 shadow-xl min-w-[220px] text-center">
                    Descargar reporte
                </a>
            </div>

        </main>
    </div>
</x-layouts::auth>