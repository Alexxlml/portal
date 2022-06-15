<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edición Colaborador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-6 px-6">
                <div class="space-y-6">
                    {{-- Inicio información personal --}}
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Información Personal</h3>
                                {{-- --}}
                                <div class="sm:row-start-1 sm:row-span-1 sm:col-start-1 sm: col-span-1 text-white">
                                    <div class="py-4 sm:px-3">
                                        <div class="flex justify-center">
                                            @if ($foto)
                                            <img class="object-cover shadow-lg rounded-lg h-52 w-40 md:h-48 md:w-36 lg:h-64 lg:w-48" src="{{ $foto->temporaryUrl() }}" alt="">
                                            @else
                                            @if (file_exists(public_path('storage/' . $colaborador->foto)))
                                            <img class="object-cover shadow-lg rounded-lg h-52 w-40 md:h-48 md:w-36 lg:h-64 lg:w-48" src="{{ asset('storage/' . $colaborador->foto) }}" alt="">
                                            @else
                                            <img class="shadow-lg rounded-lg h-52 w-40 md:h-48 md:w-36 lg:h-64 lg:w-48" src="{{ asset('images/user_silcon.png') }}" alt="">
                                            @endif
                                            @endif
                                        </div>
                                        <div>
                                        </div>

                                        <div class="flex flex-col">
                                            <div class="flex justify-center">
                                                <div class="w-40 md:w-36 lg:w-48">
                                                    <button wire:click="downloadImage" type="button" class="flex w-full flex-col my-auto items-center px-4 py-2 mt-1 tracking-wide text-verde-silconio-800 uppercase bg-white border border-verde-silconio-600 rounded-lg shadow-lg cursor-pointer hover:bg-verde-silconio-500 hover:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <div class="w-40 md:w-36 lg:w-48">
                                                    <label class="flex flex-col my-auto items-center px-4 py-2 mt-1 tracking-wide text-celeste-guia-800 uppercase bg-white border border-celeste-guia-600 rounded-lg shadow-lg cursor-pointer w-68 hover:bg-celeste-guia-500 hover:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                                                        </svg>
                                                        <input type='file' wire:model="foto" class="hidden" />
                                                    </label>
                                                    @error('foto')
                                                    <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- --}}
                            </div>
                            <div class="mt-5 md:mt-8 md:col-span-2">
                                <form wire:submit.prevent="triggerConfirm">
                                    <div class="grid grid-cols-6 gap-6">

                                        <div class="col-span-6 sm:col-span-2 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-md font-medium bg-celeste-guia-100 text-celeste-guia-800">No. Colaborador: {{ $colaborador->no_colaborador }} </span>
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 text-center">
                                            @if($colaborador->estado_colaborador == 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-md font-medium bg-red-100 text-red-800">Estado: Inactivo </span>
                                            @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-md font-medium bg-verde-silconio-100 text-verde-silconio-800">Estado: Activo </span>
                                            @endif
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-md font-medium bg-celeste-guia-100 text-celeste-guia-800"> Antigüedad: {{ $antiquity }}</span>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="nombre_1" class="block text-sm font-medium text-gray-700">Primer nombre</label>
                                            <input wire:model.lazy="nombre_1" type="text" name="nombre_1" id="nombre_1" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('nombre_1') <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p> @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="nombre_2" class="block text-sm font-medium text-gray-700">Segundo nombre</label>
                                            <input wire:model.lazy="nombre_2" type="text" name="nombre_2" id="nombre_2" autocomplete="family-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('nombre_2')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="ap_paterno" class="block text-sm font-medium text-gray-700">Apellido paterno</label>
                                            <input wire:model.lazy="ap_paterno" type="text" name="ap_paterno" id="ap_paterno" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('ap_paterno')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="ap_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                                            <input wire:model.lazy="ap_materno" type="text" name="ap_materno" id="ap_materno" autocomplete="family-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('ap_materno')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                                            <input wire:model.lazy="fecha_nacimiento" type="date" name="fecha_nacimiento" id="fecha_nacimiento" autocomplete="email" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('fecha_nacimiento')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <fieldset class="col-span-6 sm:col-span-2">
                                            <div>
                                                <legend class="text-base font-medium text-gray-900">Género</legend>
                                                <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                            </div>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="genero" id="genero_masculino" name="genero_radio" type="radio" value="1" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="genero_masculino" class="ml-3 block text-sm font-medium text-gray-700"> Masculino </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="genero" id="genero_femenino" name="genero_radio" type="radio" value="2" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="genero_femenino" class="ml-3 block text-sm font-medium text-gray-700"> Femenino </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="genero" id="genero_no_binario" name="genero_radio" type="radio" value="3" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="genero_no_binario" class="ml-3 block text-sm font-medium text-gray-700"> No Binario </label>
                                                </div>
                                            </div>
                                            @error('genero')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </fieldset>

                                        <fieldset class="col-span-6 sm:col-span-2">
                                            <div>
                                                <legend class="text-base font-medium text-gray-900">Estado Civil</legend>
                                                <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                            </div>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="estado_civil" id="estado_civil_soltero" name="estado_civil_radio" type="radio" value="1" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="estado_civil_soltero" class="ml-3 block text-sm font-medium text-gray-700"> Soltero </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="estado_civil" id="estado_civil_casado" name="estado_civil_radio" type="radio" value="2" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="estado_civil_casado" class="ml-3 block text-sm font-medium text-gray-700"> Casado </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="estado_civil" id="estado_civil_union_libre" name="estado_civil_radio" type="radio" value="3" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="estado_civil_union_libre" class="ml-3 block text-sm font-medium text-gray-700"> Unión Libre </label>
                                                </div>
                                            </div>
                                            @error('estado_civil')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </fieldset>

                                        <fieldset class="col-span-6 sm:col-span-2">
                                            <div>
                                                <legend class="text-base font-medium text-gray-900">Paternidad</legend>
                                                <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                            </div>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="paternidad" id="paternidad_no" name="paternidad_radio" type="radio" value="0" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="paternidad_no" class="ml-3 block text-sm font-medium text-gray-700"> No </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="paternidad" id="paternidad_si" name="paternidad_radio" type="radio" value="1" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="paternidad_si" class="ml-3 block text-sm font-medium text-gray-700"> Si </label>
                                                </div>
                                            </div>
                                            @error('paternidad')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </fieldset>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="curp" class="block text-sm font-medium text-gray-700">CURP</label>
                                            <input wire:model.lazy="curp" type="text" name="curp" id="curp" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('curp')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                                            <input wire:model.lazy="rfc" type="text" name="rfc" id="rfc" autocomplete="family-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('rfc')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <fieldset class="col-span-6 sm:col-span-3">
                                            <div>
                                                <legend class="text-base font-medium text-gray-900">Tipo de seguro de vida</legend>
                                                <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                            </div>
                                            <div class="mt-4 space-y-4">
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="tipo_seguro" id="tipo_seguro_sgm" name="tipo_seguro_radio" type="radio" value="1" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="tipo_seguro_sgm" class="ml-3 block text-sm font-medium text-gray-700"> Seguro GM </label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input wire:model.lazy="tipo_seguro" id="tipo_seguro_imss" name="tipo_seguro_radio" type="radio" value="2" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                    <label for="tipo_seguro_imss" class="ml-3 block text-sm font-medium text-gray-700"> IMSS </label>
                                                </div>
                                            </div>
                                            @error('tipo_seguro')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </fieldset>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="no_seguro_social" class="block text-sm font-medium text-gray-700">No. Seguro Social</label>
                                            <input wire:model.lazy="no_seguro_social" type="text" name="no_seguro_social" id="no_seguro_social" autocomplete="street-address" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('no_seguro_social')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="no_pasaporte" class="block text-sm font-medium text-gray-700">No. Pasaporte</label>
                                            <input wire:model.lazy="no_pasaporte" type="text" name="no_pasaporte" id="no_pasaporte" autocomplete="address-level2" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('no_pasaporte')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="no_visa" class="block text-sm font-medium text-gray-700">No. Visa</label>
                                            <input wire:model.lazy="no_visa" type="text" name="no_visa" id="no_visa" autocomplete="address-level1" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('no_visa')
                                            <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin información personal --}}

                    {{-- Inicio datos demográficos --}}
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Datos demográficos</h3>
                                <p class="mt-1 text-sm text-gray-500"> </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="domicilio" class="block text-sm font-medium text-gray-700">Domicilio</label>
                                        <input wire:model.lazy="domicilio" type="text" name="domicilio" id="domicilio" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('domicilio')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="colonia" class="block text-sm font-medium text-gray-700">Colonia</label>
                                        <input wire:model.lazy="colonia" type="text" name="colonia" id="colonia" autocomplete="family-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('colonia')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="municipio" class="block text-sm font-medium text-gray-700">Municipio</label>
                                        <input wire:model.lazy="municipio" type="text" name="municipio" id="municipio" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('municipio')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado / Provincia</label>
                                        <input wire:model.lazy="estado" type="text" name="estado" id="estado" autocomplete="family-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('estado')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                        <input wire:model.lazy="codigo_postal" type="text" name="codigo_postal" id="codigo_postal" autocomplete="email" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('codigo_postal')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                                        <select wire:model.lazy="nacionalidad" id="nacionalidad" name="nacionalidad" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm">
                                            <option value=""></option>
                                            @if($nacionalidades)
                                            @foreach($nacionalidades as $nacionalidad)
                                            <option value="{{ $nacionalidad->id }}">{{ $nacionalidad->gentilicio }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('nacionalidad')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin datos demográficos --}}

                    {{-- Inicio datos silcon --}}
                    <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Información de Silcon</h3>
                                <p class="mt-1 text-sm text-gray-500"> </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="oficina_asignada" class="block text-sm font-medium text-gray-700">Oficina Asignada</label>
                                        <select wire:model.lazy="oficina_asignada" id="oficina_asignada" name="oficina_asignada" autocomplete="country-office" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm">
                                            <option value=""></option>
                                            @if($oficinas)
                                            @foreach($oficinas as $oficina)
                                            <option value="{{ $oficina->id }}">{{ $oficina->region_oficina }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('oficina_asignada')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="area" class="block text-sm font-medium text-gray-700">Area</label>
                                        <select wire:model.lazy="area" id="area" name="area" autocomplete="job-title" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm">
                                            <option value=""></option>
                                            @if($areas)
                                            @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->nombre_area }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('area')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="correo" class="block text-sm font-medium text-gray-700">Correo Institucional</label>
                                        <input wire:model.lazy="correo" type="email" name="correo" id="correo" autocomplete="given-name" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('correo')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="puesto" class="block text-sm font-medium text-gray-700">Puesto</label>
                                        <select wire:model.lazy="puesto" id="puesto" name="puesto" autocomplete="job-title" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm">
                                            <option value=""></option>
                                            @if($puestos)
                                            @foreach($puestos as $puesto)
                                            <option value="{{ $puesto->id }}">{{ $puesto->puesto_completo }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('puesto')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <fieldset class="col-span-6 sm:col-span-3">
                                        <div>
                                            <legend class="text-base font-medium text-gray-900">Tipo de contrato</legend>
                                            <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                        </div>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                                <input wire:model.lazy="tipo_contrato" id="tipo_contrato_honorarios" name="tipo_contrato_radio" type="radio" value="1" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                <label for="tipo_contrato_honorarios" class="ml-3 block text-sm font-medium text-gray-700"> Honorarios </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input wire:model.lazy="tipo_contrato" id="tipo_contrato_asalariado" name="tipo_contrato_radio" type="radio" value="2" class="focus:ring-verde-silconio-500 h-4 w-4 text-verde-silconio-600 border-gray-300">
                                                <label for="tipo_contrato_asalariado" class="ml-3 block text-sm font-medium text-gray-700"> Asalariado </label>
                                            </div>
                                        </div>
                                        @error('tipo_contrato')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </fieldset>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de ingreso</label>
                                        <input wire:model.lazy="fecha_ingreso" type="date" name="fecha_ingreso" id="fecha_ingreso" autocomplete="email" class="mt-1 focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('fecha_ingreso')
                                        <p class="mt-1 mb-1 text-xs text-red-600 italic">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- Fin datos silcon --}}

                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-verde-silconio-600 hover:bg-verde-silconio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-verde-silconio-500">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
