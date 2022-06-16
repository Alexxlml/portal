<div>
    <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <div class="flex">
                        <div class="basis-1/4 px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                            <select wire:model='perPage' class=" border-gray-300 rounded-md shadow-sm focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm mr-4">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="basis-1/4 grow px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                            <button wire:click="showModal" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-verde-silconio-600 hover:bg-verde-silconio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-verde-silconio-500">
                                <!-- Heroicon name: solid/mail -->
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" />
                                    <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                                </svg>
                                Cargar
                            </button>
                        </div>
                        <div class="basis-3/4 grow px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                            <input wire:model="search" type="text" placeholder="Buscar" class="w-full col-span-3 border-gray-300 rounded-md shadow-sm focus:ring-verde-silconio-500 focus:border-verde-silconio-500 sm:text-sm">
                        </div>
                    </div>
                </tr>
                @if ($facturas->count())
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Año y Mes</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Quincena</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Comentarios</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">PDF</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">XML</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">Eliminar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($facturas as $factura)
                <tr>
                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                        <div class="flex flex-col items-start">
                            <div class="">{{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->year) }}</div>
                            <div class="">{{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->monthName) }}</div>
                        </div>
                        {{-- Vista Mobile --}}
                        <dl class="font-normal lg:hidden">
                            <dt class="sr-only">Title</dt>
                            <dd class="mt-1 truncate text-gray-500 sm:hidden">No. Quincena: {{ $factura->no_quincena }}</dd>
                            <dt class="sr-only sm:hidden">Email</dt>
                            <dd class="mt-1 truncate text-gray-500 sm:hidden">Comentarios: {{ $factura->comentarios }}</dd>
                        </dl>
                    </td>
                    {{-- Vista Tablet>>>Escritorio --}}
                    <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                        <div class="ml-4">{{ $factura->no_quincena }}</div>
                    </td>

                    <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                        <div class="ml-4">{{ $factura->comentarios }}</div>
                    </td>


                    <td class="py-4 pl-3 pr-3 text-right text-sm font-medium sm:pr-6">
                        <div class="flex justify-center py-4 cursor-pointer">
                            <div class="transform text-celeste-guia-500 hover:text-celeste-guia-700 hover:scale-150">
                                <button wire:click="descarga({{ $factura->id }}, '1')" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 pl-3 pr-3 text-right text-sm font-medium sm:pr-6">
                        <div class="flex justify-center py-4 cursor-pointer">
                            <div class="transform text-celeste-guia-500 hover:text-celeste-guia-700 hover:scale-150">
                                <button wire:click="descarga({{ $factura->id }}, '2')" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 pl-3 pr-3 text-right text-sm font-medium sm:pr-6">
                        <div class="flex justify-center py-4 cursor-pointer">
                            <div class="transform text-red-500 hover:text-red-700 hover:scale-150">
                                <button wire:click="triggerConfirm({{ $factura->id }})" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <!-- More people... -->
            </tbody>
        </table>
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            {{ $facturas->links() }}
        </div>
        @else
        <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
            <h6 class="text-center text-gray-500">No se encontró ningún campo que coincida con:
                "{{ $search }}"</h6>
        </div>
        @endif
    </div>

    <x-jet-dialog-modal wire:model="switchModalSubida">
        <x-slot name="title">
            Formulario de carga
        </x-slot>
        @if($facturas_quincena == 2)
        <x-slot name="content">
            Ya no puedes subir mas facturas
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('switchModalSubida', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
        </x-slot>

        @else
        <x-slot name="content">
            <div class="mb-4">
                <p>Carga aquí tus archivos</p>
                <p class="text-xs text-slate-600">Facturas que puedes subir este mes: {{ (2 - $facturas_quincena) }}</p>
            </div>
            <div class="">
                <label class="block">
                    <label class="ml-2">Elige tu PDF</label>
                    <input wire:model="f_pdf" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-celeste-guia-50 file:text-celeste-guia-700 hover:file:bg-celeste-guia-100" />
                </label>
                @error('f_pdf')
                <p class="mt-1 mb-1 text-xs text-red-600 italic">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="mt-4">
                <label class="block">
                    <label class="ml-2">Elige tu XML</label>
                    <input wire:model="fXml" type="file" accept=".xml" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-celeste-guia-50 file:text-celeste-guia-700 hover:file:bg-celeste-guia-100" />
                </label>
                @error('f_xml')
                <p class="mt-1 mb-1 text-xs text-red-600 italic">
                    {{ $message }}
                </p>
                @enderror
                <div class="mt-8">
                    <label for="comment" class="block text-sm font-medium text-gray-700">Agrega un comentario (opcional)</label>
                    <div class="mt-1">
                        <textarea wire:model.lazy="comentarios" rows="4" name="comment" id="comment" class="shadow-sm focus:ring-verde-silconio-500 focus:border-verde-silconio-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('switchModalSubida', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-jet-secondary-button>
            @if($switchXml == true)
            <x-jet-button class="ml-2" wire:click="cargaFactura()" wire:loading.attr="disabled">
                {{ __('Subir') }}
            </x-jet-button>
            @endif
        </x-slot>
        @endif()
    </x-jet-dialog-modal>
</div>
