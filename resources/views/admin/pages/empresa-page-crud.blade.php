@section('title', 'Lista de Empresas - BOLSALABORAL')
@section('header', 'Lista de Empresas')
@section('section', 'BOLSALABORAL')

<div>
    <div>
        <div class="flex flex-col sm:flex-row sm:justify-between text-center gap-2 mb-4">
            <div class="flex-1">
                <div class="relative flex items-center text-gray-400 focus-within:text-green-500">
                    <span class="absolute left-4 h-6 flex items-center pr-3 border-r border-gray-300">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" wire:model="search" placeholder="Buscar por nombre..."
                        class="w-full pl-14 pr-4 py-2.5 rounded-lg text-sm text-gray-600 outline-none border border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-lg">
                </div>
            </div>
            <div class="flex justify-center gap-2" align="right">
                {{-- <a href="{{ URL::to('/categorias/csv') }}"
                    class="px-4 py-2 flex gap-1 items-center rounded-lg bg-gradient-to-r from-emerald-700 to-green-600 focus:from-emerald-700 focus:to-green-600 active:from-green-600 active:to-green-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-regular fa-file-excel"></i> csv
                </a>
                <a href="{{ URL::to('/categorias/pdf') }}" target="_blank"
                    class="px-4 py-2 flex gap-1 items-center rounded-lg bg-gradient-to-r from-sky-900 to-blue-700 focus:from-sky-900 focus:to-blue-700 active:from-sky-700 active:to-blue-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-regular fa-file-lines"></i> pdf
                </a> --}}
                <button wire:click="create()"
                    class="px-4 py-2 rounded-lg bg-gradient-to-r from-amber-700 to-yellow-600 focus:from-amber-700 focus:to-yellow-600 active:from-amber-600 active:to-yellow-600 text-sm text-white font-semibold tracking-wide cursor-pointer shadow-lg">
                    <i class="fa-solid fa-plus"></i> Nuevo
                </button>
                @if ($isOpen)
                    @include('admin.modals.empresas')
                @endif
            </div>
        </div>
        <div class="shadow-lg border-b border-gray-200 rounded-lg overflow-auto">
            <table class="w-full table-auto">
                <thead class="bg-indigo-700 text-white">
                    <tr class="text-center text-xs font-bold uppercase">
                        <td scope="col" class="px-6 py-3">ID</td>
                        <td scope="col" class="px-6 py-3">Razon Social</td>
                        <td scope="col" class="px-6 py-3">Logo Empresa</td>
                        <td scope="col" class="px-6 py-3">RUC</td>
                        <td scope="col" class="px-6 py-3">Direccion</td>
                        <td scope="col" class="px-6 py-3">Telefono</td>
                        <td scope="col" class="px-6 py-3">Correo</td>
                        <td scope="col" class="px-6 py-3">Usuario</td>
                        <td scope="col" class="px-6 py-3">Creacion</td>
                        <td scope="col" class="px-6 py-3">Actualizado</td>
                        <th scope="col" class="px-4 py-3 ">acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 bg-white">
                    @foreach ($empresas as $index => $item)
                        <tr class="text-sm font-medium text-gray-900 hover:bg-gray-100">
                            <td class="p-4">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-700 text-white">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-4 text-center">{{ $item->ra_social }}</td>
                            <td class="p-2">
                                <img class="w-24 h-24 object-cover rounded-lg"
                                    src="{{ $item->image ? Storage::url($item->image->url) : '/img/default.jpg' }}" />
                            </td>
                            {{-- <td class="p-4">
                                <div class="flex justify-center items-center">
                                    @if ($item->state == 1)
                                        <span
                                            class="italic text-white bg-gradient-to-r from-orange-600 to-amber-600 rounded-xl px-3 py-1 shadow-md text-sm">
                                            Escondido
                                        </span>
                                    @else
                                        <span
                                            class="italic text-white bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl px-3 py-1 shadow-md text-sm">
                                            Visible
                                        </span>
                                    @endif
                                </div>
                            </td> --}}
                            <td class="p-4 text-center">{{ $item->ruc }}</td>
                            <td class="p-4 text-center">{{ $item->direccion }}</td>
                            <td class="p-4 text-center">{{ $item->correo }}</td>
                            <td class="p-4 text-center">{{ $item->telefono }}</td>
                            <td class="p-4 text-center">{{ $item->user->name }}</td>
                            <td class="p-4 text-center">{{ $item->created_at }}</td>
                            <td class="p-4 text-center">{{ $item->updated_at }}</td>
                            <td class="p-4 acciones w-10 space-y-2">
                                {{-- @livewire('cliente-edit',['cliente'=>$itemo],key($itemo->id)) --}}
                                <x-button wire:click="edit({{ $item }})" class="rounded-md">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </x-button>
                                <x-button-danger wire:click="$emit('deleteItem',{{ $item->id }})"
                                    class="rounded-md">
                                    <i class="fa-regular fa-trash-can"></i>
                                </x-button-danger>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (!$empresas->count())
            <div class="flex h-auto items-center justify-center p-5 bg-white w-full rounded-lg shadow-lg">
                <div class="text-center">
                    <div class="inline-flex rounded-full bg-yellow-100 p-4">
                        <div class="rounded-full text-yellow-600 bg-yellow-200 p-4 text-6xl">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                    </div>
                    <h1 class="mt-5 text-2xl font-bold text-slate-800">Ups... algo salio mal</h1>
                    <p class="text-slate-600 mt-2 text-base">No existe ningun registro coincidente con la busqueda </p>
                    <span class="text-slate-600 mt-2 text-base">Por favor ingrese el texto correctamente</span>
                </div>
            </div>
        @endif
        @if ($empresas->hasPages())
            <div class="px-6 py-3">
                {{ $empresas->links() }}
            </div>
        @endif
    </div>

    <!--Scripts - Sweetalert   -->
    @push('js')
        <script>
            Livewire.on('deleteItem', id => {
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //alert("del");
                        Livewire.emitTo('empresa-page-crud', 'delete', id);
                        Swal.fire(
                            '¡Eliminado!',
                            'Su archivo ha sido eliminado.',
                            'success'
                        )

                    }
                })
            });
        </script>
    @endpush
</div>
