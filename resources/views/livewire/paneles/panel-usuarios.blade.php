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
            @if ($colaboradores->count())
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Puesto y Area</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Correo</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Oficina</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($colaboradores as $colaborador)
            <tr>
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                    <div class="flex items-center">
                        <div class="h-20 w-20 flex-shrink-0">
                            <img class="h-20 w-20 rounded-full" src="{{ asset('storage/' . $colaborador->foto) }}" alt="">
                        </div>
                        <div class="ml-4">{{ $colaborador->nombre_completo }}</div>
                    </div>
                    {{-- Vista Mobile --}}
                    <dl class="font-normal lg:hidden">
                        <dt class="sr-only">Title</dt>
                        <dd class="mt-1 truncate text-gray-700">{{ $colaborador->puesto }}</dd>
                        <dt class="sr-only sm:hidden">Email</dt>
                        <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ $colaborador->correo }}</dd>
                    </dl>
                </td>
                {{-- Vista Tablet>>>Escritorio --}}
                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                <div>{{ $colaborador->puesto }}</div>
                <div>{{ $colaborador->nombre_area }}</div>
                </td>

                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $colaborador->correo }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $colaborador->region_oficina }}</td>
                <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </td>
            </tr>
            @endforeach
            <!-- More people... -->
        </tbody>
    </table>
    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
        {{ $colaboradores->links() }}
    </div>
    @else
    <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
        <h6 class="text-center text-gray-500">No se encontró ningún campo que coincida con:
            "{{ $search }}"</h6>
    </div>
    @endif
</div>
