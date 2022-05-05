<div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <div class="flex">
                    <div class="basis-1/4 px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                        <select wire:model='perPage' class=" border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mr-4">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="basis-3/4 grow px-2 py-2 bg-white border-t border-gray-200 sm:px-3">
                        <input wire:model="search" type="text" placeholder="Buscar" class="w-full col-span-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
            </tr>
            @if ($facturas->count())
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Año y Mes</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Quincena</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">PDF</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">XML</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($facturas as $factura)
            <tr>
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                    <div class="flex items-center">
                        <div class="">{{ $factura->nombre_completo }}</div>
                    </div>
                    {{-- Vista Mobile --}}
                    <dl class="font-normal lg:hidden">
                        <dt class="sr-only">Title</dt>
                        <dd class="mt-1 truncate text-gray-700">
                            <div>Año: {{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->year) }}</div>
                            <div>Mes: {{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->monthName) }}</div>
                        </dd>
                        <dt class="sr-only sm:hidden">Email</dt>
                        <dd class="mt-1 truncate text-gray-500 sm:hidden">No. Quincena: {{ $factura->no_quincena }}</dd>
                    </dl>
                </td>
                {{-- Vista Tablet>>>Escritorio --}}
                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                    <div class="ml-2">{{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->year) }}</div>
                    <div class="ml-2">{{ ucwords(\Carbon\Carbon::parse($factura->created_at)->locale('es')->monthName) }}</div>
                </td>

                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                    <div class="ml-4">{{ $factura->no_quincena }}</div>
                </td>


                <td class="py-4 pl-3 pr-3 text-right text-sm font-medium sm:pr-6">
                    <div class="flex justify-center py-4 cursor-pointer">
                        <div class="transform text-blue-500 hover:text-blue-700 hover:scale-150">
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
                        <div class="transform text-blue-500 hover:text-blue-700 hover:scale-150">
                            <button wire:click="descarga({{ $factura->id }}, '2')" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
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
