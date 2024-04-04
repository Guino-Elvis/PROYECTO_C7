<div>
    <x-dialog-modal wire:model="isOpen" maxWidth="lg">
        <x-slot name="title">
            @if ($ruteCreate)
                <h3 class="text-center">Registrar nueva Empresa</h3>
            @else
                <h3 class="text-center">Actualizar Empresa</h3>
            @endif
        </x-slot>
        <x-slot name="content">
            <form autocomplete="off">
                {{-- <input type="hidden" name="user_id" value="{{ Auth::id() }}"> --}}
                <input type="hidden" wire:model="empresa.id">
                <div class="flex flex-col sm:flex-row gap-2.5 w-full px-2">
                    <div class="flex flex-col gap-2.5 w-full">
                        <div  class="mb-1 w-full">
                            <x-label value="Nombre de la Empresa" class="font-bold" />
                            <x-input type="text" wire:model="empresa.ra_social" />
                            @unless (!empty($empresa['ra_social']))
                                <x-input-error for="empresa.ra_social" />
                            @endunless
                        </div>
                        <div>
                            <x-label value="RUC de la Empresa" class="font-bold" />
                            <x-input type="text" wire:model="empresa.ruc"  />
                            @unless (!empty($empresa['ruc']))
                                <x-input-error for="empresa.ruc" />
                            @endunless
                        </div>
                        <div>
                            <x-label value="Direccion de la Empresa" class="font-bold" />
                            <x-input type="text" wire:model="empresa.direccion" />
                            @unless (!empty($empresa['direccion']))
                                <x-input-error for="empresa.direccion" />
                            @endunless
                        </div>
                        <div>
                            <x-label value="Telefono de la Empresa" class="font-bold" />
                            <x-input type="text" wire:model="empresa.telefono" />
                            @unless (!empty($empresa['telefono']))
                                <x-input-error for="empresa.telefono" />
                            @endunless
                        </div>
                        <div>
                            <x-label value="Correo de la Empresa" class="font-bold" />
                            <x-input type="text" wire:model="empresa.correo" />
                            @unless (!empty($empresa['correo']))
                                <x-input-error for="empresa.correo" />
                            @endunless
                        </div>
                        {{-- <div class="flex flex-col sm:flex-row gap-2.5">
                            <div class="flex-auto">
                                <x-label value="Estado" class="font-bold" />
                                <x-select wire:model="empresa.state">
                                    <x-slot name="options">
                                        @if ($ruteCreate)
                                            <option value="" selected>Seleccione...</option>
                                            <option value="1">Escondido</option>
                                            <option value="2">Visible</option>
                                        @else
                                            @if ($empresa['state'] == 1)
                                                <option value="{{ $empresa['state'] }}" selected>Escondido</option>
                                                <option value="2">Visible</option>
                                            @else
                                                <option value="{{ $empresa['state'] }}" selected>Visible</option>
                                                <option value="1">Escondido</option>
                                            @endif
                                        @endif
                                    </x-slot>
                                </x-select>
                                @unless (!empty($empresa['state']))
                                    <x-input-error for="empresa.state" />
                                @endunless
                            </div>
                            <input hidden wire:model="empresa.user" />
                            <input hidden wire:model="empresa.company" />
                        </div> --}}
                        {{-- <div class="flex flex-col sm:flex-row gap-2.5">
                            <div class="flex-auto">
                                <x-label for="category" value="Categoría" class="font-bold" />
                                <select wire:model="empresa.category_id" id="category" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" selected>Seleccione una categoría...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('empresa.category_id')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>                         --}}
                    </div>
                    <div class="w-full">
                        <x-label value="Imagen" class="font-bold" />
                        <div>
                            <div class="border border-gray-300 rounded-lg">
                                <label
                                    class="text-white text-sm rounded-t-lg bg-gray-600 focus:bg-gray-600 active:bg-gray-700 inline-flex items-center justify-center w-full px-4 py-2 cursor-pointer">
                                    <i class="fa-solid fa-upload mr-1"></i>Cargar Imagen
                                    <input wire:model="image" type="file" hidden />
                                </label>

                                <div wire:loading wire:target="image" class="w-full">
                                    <div id="alert-4"
                                        class="flex items-center justify-center p-3 mb-4 text-yellow-800 rounded-lg bg-yellow-50"
                                        role="alert">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <div class="ml-2 text-xs font-medium">
                                            Espere un momento por favor, la(s) imagen(es) se esta procesando
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 py-2.5">
                                    @if ($ruteCreate)
                                        @if ($image)
                                            <img class="mx-auto w-32 h-32 object-cover rounded-md"
                                                src="{{ $image->temporaryUrl() }}" alt="">
                                        @else
                                            <li id="empty"
                                                class="h-full w-full text-center flex flex-col items-center justify-center">
                                                <img class="mx-auto w-32"
                                                    src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                                    alt="no data" />
                                                <span class="text-small text-gray-500">
                                                    Ningún archivo seleccionado</span>
                                            </li>
                                        @endif
                                    @else
                                        @if ($image)
                                            <img class="mx-auto w-32 h-32 object-cover rounded-md"
                                                src="{{ $image->temporaryUrl() }}" alt="">
                                        @else
                                            <img class="mx-auto w-32 h-32 object-cover rounded-md"
                                            src="/img/default.jpg"
                                                alt="">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <x-button-danger wire:click="$set('isOpen',false)">Cancelar</x-button-danger>
            <x-button-success wire:click.prevent="store()" wire:loading.attr="disabled" wire:target="store, image"
                class="disabled:opacity-25">
                @if ($ruteCreate)
                    Registrar
                @else
                    Actualizar
                @endif
            </x-button-success>
        </x-slot>

    </x-dialog-modal>
</div>
