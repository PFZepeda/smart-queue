<x-layouts::auth>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Source+Sans+3:wght@400;500;600&display=swap');
        
        /* Ocultar el ojo nativo de los navegadores */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
        input[type="password"]::-webkit-reveal,
        input[type="password"]::-webkit-clear-button {
            display: none !important;
        }

        @media (max-height: 760px) {
            .employee-wrapper {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="employee-wrapper fixed inset-0 flex flex-col items-center justify-start lg:justify-center bg-[#0C4D8B] z-50 font-['Source_Sans_3'] overflow-y-auto py-5 sm:py-8 px-4 sm:px-6">
        {{-- LOGO --}}
        <div class="mb-5 sm:mb-6 text-center flex flex-col items-center shrink-0">
            <img src="{{ asset('images/Logo_1.svg') }}" alt="Logo NovaBank" class="w-[150px] sm:w-[190px] lg:w-[220px] h-auto object-contain">
        </div>

        <div class="w-full max-w-6xl mx-auto flex flex-col xl:flex-row justify-center items-stretch gap-5 sm:gap-7 xl:gap-8">
            {{-- Panel Crear Empleado --}}
            <div class="w-full max-w-[440px] xl:max-w-[440px] mx-auto xl:mx-0 flex flex-col bg-[#072b4e] px-5 sm:px-8 lg:px-10 py-6 sm:py-10 rounded-[1.3rem] sm:rounded-[1.5rem] shadow-2xl border border-white/5 shrink-0">
                <div class="w-full text-center mb-6 sm:mb-8">
                    <h2 class="text-white text-[1.1rem] sm:!text-[1.4rem] font-semibold tracking-wide">Crear cuenta Empleado</h2>
                </div>
                <form method="POST" action="{{ route('admin.register-employee.store') }}" class="flex flex-col gap-3 sm:gap-4">
                    @csrf
                    @if (session('success'))
                        <p class="text-emerald-400 !text-[13px] text-center font-medium">
                            {{ session('success') }}
                        </p>
                    @endif

                    <div class="flex flex-col">
                        <label class="text-white/90 text-[13px] mb-1">Introduce el Nombre: <span class="text-red-500">*</span></label>
                        <input type="text" name="name" placeholder="Nombre Completo" required value="{{ old('name') }}"
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-5 sm:px-6 focus:ring-2 focus:ring-[#02B48A] outline-none !text-[15px] placeholder:!text-[15px] transition-all">
                        @error('name')
                            <p class="text-[#ef4444] !text-[12px] text-center mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-white/90 text-[13px] mb-1">Introduce el Correo: <span class="text-red-500">*</span></label>
                        <input type="email" name="email" placeholder="Correo" required value="{{ old('email') }}"
                            class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-5 sm:px-6 focus:ring-2 focus:ring-[#02B48A] outline-none !text-[15px] placeholder:!text-[15px] transition-all">
                        @error('email')
                            <p class="text-[#ef4444] !text-[12px] text-center mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col" x-data="{ show: false }">
                        <label class="text-white/90 text-[13px] mb-1">Introduce la Contraseña: <span class="text-red-500">*</span></label>
                        <div class="relative w-full">
                            <input :type="show ? 'text' : 'password'" name="password" placeholder="Contraseña" required
                                class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-5 sm:px-6 pr-12 focus:ring-2 focus:ring-[#02B48A] outline-none !text-[15px] placeholder:!text-[15px] transition-all">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @if($errors->has('password') && !str_contains($errors->first('password'), 'coinciden'))
                            <p class="text-[#ef4444] !text-[12px] text-center mt-2 font-medium">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col" x-data="{ show: false }">
                        <label class="text-white/90 text-[13px] mb-1">Confirma la Contraseña: <span class="text-red-500">*</span></label>
                        <div class="relative w-full">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirmar contraseña" required
                                class="w-full bg-[#3B4B5B] text-white border-none rounded-full py-2.5 sm:py-3 px-5 sm:px-6 pr-12 focus:ring-2 focus:ring-[#02B48A] outline-none !text-[15px] placeholder:!text-[15px] transition-all">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-white focus:outline-none">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @if($errors->has('password') && str_contains($errors->first('password'), 'coinciden'))
                            <p class="text-[#ef4444] !text-[12px] text-center mt-2 font-medium">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-[#02B48A] hover:bg-[#029A73] text-white font-medium py-3 rounded-full mt-2 transition-all shadow-lg active:scale-95 !text-[15px] sm:!text-[16px]">
                        Registrar Empleado
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-1/2 mx-auto text-center bg-[#02B48A] hover:bg-[#029A73] text-white font-medium py-2 rounded-full mt-3 transition-all shadow-lg active:scale-95 !text-[15px]">
                        Regresar
                    </a>
                </form>
            </div>

            {{-- Panel Lista Empleados --}}
            <div class="w-full max-w-xl xl:max-w-xl mx-auto xl:mx-0 flex flex-col bg-[#072b4e] px-4 sm:px-8 py-6 sm:py-10 rounded-[1.3rem] sm:rounded-[1.5rem] shadow-2xl border border-white/5 shrink-0 overflow-x-auto">
                <div class="w-full text-center mb-6 sm:mb-8">
                    <h2 class="text-white text-[1.05rem] sm:!text-[1.3rem] font-semibold tracking-wide">Lista Empleados</h2>
                </div>
                @if(session('error'))
                    <div class="bg-red-500/20 border border-red-400 text-red-100 px-4 py-2 rounded-xl mb-4 text-center">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="w-full min-w-[520px] sm:min-w-0 text-white text-center text-[13px] sm:text-[14px] table-auto border-separate border-spacing-y-2">
                    <thead>
                        <tr>
                            <th class="text-center align-middle px-2 py-2"></th>
                            <th class="text-center align-middle px-2 py-2">Nombre</th>
                            <th class="text-center align-middle px-2 py-2">Área designada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados ?? [] as $empleado)
                        <tr x-data="{ open: false }" class="align-middle">
                            <td class="text-center align-middle px-2 py-2">
                                <form x-ref="delForm" method="POST" action="{{ route('admin.register-employee.destroy', $empleado->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="open = true" class="bg-[#B21321] hover:bg-[#900f1a] text-white rounded-full p-2 transition duration-200 active:scale-95 shadow" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-5 0a1 1 0 001-1h2a1 1 0 001 1m-4 0H6m12 0h-3M9 10v8m6-8v8" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Modal de confirmación --}}
                                <div x-show="open" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center">
                                    <div class="absolute inset-0 bg-black/60" @click="open = false"></div>
                                    <div class="relative bg-[#072b4e] w-[92%] max-w-xl rounded-[1.3rem] sm:rounded-[1.5rem] border border-white/10 p-5 sm:p-8 mx-4">
                                        <h3 class="text-center text-red-500 font-extrabold text-[1.35rem] sm:text-2xl tracking-widest mb-4">PRECAUCION !!</h3>
                                        <p class="text-center text-white/90 mb-5 sm:mb-6 text-[14px] sm:text-[16px]">¿Estás seguro de eliminar este empleado?</p>
                                        <div class="bg-[#4D647C] text-white/90 rounded-3xl p-4 sm:p-6 mb-5 sm:mb-6 text-[14px] sm:text-[16px]">
                                            <p class="mb-2">Una vez eliminado, esta acción no se puede deshacer.</p>
                                            <p>• Se perderán los datos asociados del empleado.</p>
                                        </div>
                                        <div class="flex flex-col gap-3">
                                            <button class="w-full text-white font-bold py-3 rounded-2xl transition duration-200 active:scale-95 shadow-md"
                                                style="background-color:#B21321"
                                                @click="$refs.delForm.submit()">
                                                Eliminar Empleado
                                            </button>
                                            <button class="w-full bg-[#02B48A] hover:bg-[#019875] text-white font-bold py-3 rounded-2xl transition duration-200 active:scale-95 shadow-md"
                                                @click="open = false">
                                                Regresar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle px-2 py-2">{{ $empleado->name }}</td>
                            <td class="text-center align-middle px-2 py-2">
                                <form method="POST" action="{{ route('admin.register-employee.asignar-area', $empleado->id) }}">
                                    @csrf
                                    <select name="area_designada" class="w-full sm:w-auto bg-[#3B4B5B] text-white rounded-full px-4 py-2 text-center" onchange="this.form.submit()">
                                        <option value="">Sin asignar</option>
                                        @foreach($areas ?? [] as $area)
                                            <option value="{{ $area }}" @if($empleado->area_designada == $area) selected @endif @if(($empleados ?? collect())->where('area_designada', $area)->count() > 0 && $empleado->area_designada != $area) disabled @endif>{{ $area }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::auth>
