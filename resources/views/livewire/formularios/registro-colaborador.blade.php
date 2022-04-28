<div>
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
                                <img class="shadow-lg rounded-lg h-52 w-40 md:h-48 md:w-36 lg:h-64 lg:w-48" src="{{ $foto->temporaryUrl() }}" alt="">
                                @else
                                <img class="shadow-lg rounded-lg h-52 w-40 md:h-48 md:w-36 lg:h-64 lg:w-48" src="{{ asset('images/user_silcon.png') }}" alt="">
                                @endif
                            </div>
                            <div>
                                {{-- @if ($foto)
                                <img src="{{ $foto->temporaryUrl() }}" class="mx-auto rounded-xl border-2 shadow-xl w-38 h-48">
                                @else --}}

                                {{-- @if (file_exists(public_path('storage/' . $colaborador->foto)))
                                <img class="mx-auto rounded-xl border-2 shadow-xl w-38 h-48" src="{{ asset('storage') . '/' . $colaborador->foto }}" alt="">
                                @else --}}
                                {{-- <img class="mx-auto rounded-xl border-2 shadow-xl w-24 h-48" src="{{ asset('images/user_silcon.png') }}" alt=""> --}}
                                {{-- @endif
                                @endif --}}
                            </div>

                            <div class="flex justify-center">

                                {{-- <div class="sm:row-start-1 sm:row-span-1 sm:col-start-1 sm:col-span-1">
                                    <button wire:click="downloadImage" type="button" class="flex w-36 md:w-full flex-col my-auto items-center px-4 py-2 mt-1 tracking-wide text-green-800 uppercase bg-white border border-green-600 rounded-lg shadow-lg cursor-pointer w-68 hover:bg-green-500 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div> --}}
                                <div class="w-40 md:w-36 lg:w-48">
                                    <label class="flex flex-col my-auto items-center px-4 py-2 mt-1 tracking-wide text-blue-800 uppercase bg-white border border-blue-600 rounded-lg shadow-lg cursor-pointer w-68 hover:bg-blue-500 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                                        </svg>
                                        <input type='file' wire:model="foto" class="hidden" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- --}}
                </div>
                <div class="mt-5 md:mt-8 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nombre_1" class="block text-sm font-medium text-gray-700">Primer nombre</label>
                                <input type="text" name="nombre_1" id="nombre_1" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nombre_2" class="block text-sm font-medium text-gray-700">Segundo nombre</label>
                                <input type="text" name="nombre_2" id="nombre_2" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="ap_paterno" class="block text-sm font-medium text-gray-700">Apellido paterno</label>
                                <input type="text" name="ap_paterno" id="ap_paterno" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="ap_materno" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                                <input type="text" name="ap_materno" id="ap_materno" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6">
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <fieldset class="col-span-6 sm:col-span-2">
                                <div>
                                    <legend class="text-base font-medium text-gray-900">Género</legend>
                                    <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="genero_masculino" name="genero_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="genero_masculino" class="ml-3 block text-sm font-medium text-gray-700"> Masculino </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="genero_femenino" name="genero_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="genero_femenino" class="ml-3 block text-sm font-medium text-gray-700"> Femenino </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="genero_no_binario" name="genero_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="genero_no_binario" class="ml-3 block text-sm font-medium text-gray-700"> No Binario </label>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="col-span-6 sm:col-span-2">
                                <div>
                                    <legend class="text-base font-medium text-gray-900">Estado Civil</legend>
                                    <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="estado_civil_soltero" name="estado_civil_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="estado_civil_soltero" class="ml-3 block text-sm font-medium text-gray-700"> Soltero </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="estado_civil_casado" name="estado_civil_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="estado_civil_casado" class="ml-3 block text-sm font-medium text-gray-700"> Casado </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="estado_civil_union_libre" name="estado_civil_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="estado_civil_union_libre" class="ml-3 block text-sm font-medium text-gray-700"> Unión Libre </label>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="col-span-6 sm:col-span-2">
                                <div>
                                    <legend class="text-base font-medium text-gray-900">Paternidad</legend>
                                    <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="paternidad_si" name="paternidad_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="paternidad_si" class="ml-3 block text-sm font-medium text-gray-700"> Si </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="paternidad_no" name="paternidad_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="paternidad_no" class="ml-3 block text-sm font-medium text-gray-700"> No </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="curp" class="block text-sm font-medium text-gray-700">CURP</label>
                                <input type="text" name="curp" id="curp" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                                <input type="text" name="rfc" id="rfc" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <fieldset class="col-span-6 sm:col-span-3">
                                <div>
                                    <legend class="text-base font-medium text-gray-900">Tipo de seguro de vida</legend>
                                    <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="tipo_seguro_sgm" name="tipo_seguro_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="tipo_seguro_sgm" class="ml-3 block text-sm font-medium text-gray-700"> Seguro GM </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="tipo_seguro_imss" name="tipo_seguro_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="tipo_seguro_imss" class="ml-3 block text-sm font-medium text-gray-700"> IMSS </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="no_seguro_social" class="block text-sm font-medium text-gray-700">No. Seguro Social</label>
                                <input type="text" name="no_seguro_social" id="no_seguro_social" autocomplete="street-address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="no_pasaporte" class="block text-sm font-medium text-gray-700">No. Pasaporte</label>
                                <input type="text" name="no_pasaporte" id="no_pasaporte" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="no_visa" class="block text-sm font-medium text-gray-700">No. Visa</label>
                                <input type="text" name="no_visa" id="no_visa" autocomplete="address-level1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </form>
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
                    <form action="#" method="POST">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nombre_1" class="block text-sm font-medium text-gray-700">Domicilio</label>
                                <input type="text" name="nombre_1" id="nombre_1" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nombre_2" class="block text-sm font-medium text-gray-700">Colonia</label>
                                <input type="text" name="nombre_2" id="nombre_2" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="ap_paterno" class="block text-sm font-medium text-gray-700">Municipio</label>
                                <input type="text" name="ap_paterno" id="ap_paterno" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="ap_materno" class="block text-sm font-medium text-gray-700">Estado / Provincia</label>
                                <input type="text" name="ap_materno" id="ap_materno" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="email" name="codigo_postal" id="codigo_postal" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                                <select id="nacionalidad" name="nacionalidad" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                        </div>
                    </form>
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
                    <form action="#" method="POST">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="oficina_asignada" class="block text-sm font-medium text-gray-700">Oficina Asignada</label>
                                <select id="oficina_asignada" name="oficina_asignada" autocomplete="country-office" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>Costa Rica</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="puesto" class="block text-sm font-medium text-gray-700">Area</label>
                                <select id="puesto" name="puesto" autocomplete="job-title" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>Software Development</option>
                                    <option>Design</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Institucional</label>
                                <input type="email" name="correo" id="correo" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="puesto" class="block text-sm font-medium text-gray-700">Puesto</label>
                                <select id="puesto" name="puesto" autocomplete="job-title" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>Jr. Software Developer</option>
                                    <option>Sr. Software Developer</option>
                                </select>
                            </div>

                            <fieldset class="col-span-6 sm:col-span-3">
                                <div>
                                    <legend class="text-base font-medium text-gray-900">Tipo de contrato</legend>
                                    <p class="text-sm text-gray-500">Elige una de las siguientes opciones</p>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input id="tipo_contrato_honorarios" name="tipo_contrato_radio" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="tipo_contrato_honorarios" class="ml-3 block text-sm font-medium text-gray-700"> Honorarios </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de ingreso</label>
                                <input type="date" name="fecha_ingreso" id="fecha_ingreso" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Fin datos silcon --}}

        <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Guardar</button>
        </div>
    </div>
</div>
