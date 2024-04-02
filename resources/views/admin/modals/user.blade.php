<div>
    <x-dialog-modal wire:model="isOpen" maxWidth="lg">
        <x-slot name="title">
            @if ($ruteCreate)
                <h3 class="text-center">Registrar nueva categoria</h3>
            @else
                <h3 class="text-center">Actualizar categoria</h3>
            @endif
        </x-slot>
        <x-slot name="content">
            <form autocomplete="off">
                <input type="hidden" wire:model="user.id">
                <div class="flex flex-col gap-2.5 w-full px-2">
                    <div class="mb-1">
                        <x-label value="Nombre" class="font-bold" />
                        <x-input type="text" wire:model="user.name" />
                        @unless (!empty($user['name']))
                            <x-input-error for="user.name" />
                        @endunless
                    </div>
                    <div>
                        <x-label value="Correo" class="font-bold" />
                        <x-input type="text" wire:model="user.email" />
                        @unless (!empty($user['email']))
                            <x-input-error for="user.email" />
                        @endunless
                    </div>
                    <div>
                        <x-label value="Contraseña" class="font-bold" />
                        <div class="relative" x-data="{ showPas: false }">
                            <input type="password" wire:model="user.password"
                                placeholder="••••••••" :type="showPas ? 'text' : 'password'"
                                class="text-sm w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                                <div class="h-5 text-gray-700 py-0.5" @click="showPas = !showPas"
                                    :class="{ 'block': !showPas, 'hidden': showPas }">
                                    <i class="fa-solid fa-eye fa-lg"></i>
                                </div>
                                <div class="h-5 text-gray-700 py-0.5" @click="showPas = !showPas"
                                    :class="{ 'hidden': !showPas, 'block': showPas }">
                                    <i class="fa-solid fa-eye-slash fa-lg"></i>
                                </div>
                            </div>
                        </div>
                        @unless (!empty($user['password']))
                            <x-input-error for="user.password" />
                        @endunless
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
