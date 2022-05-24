<x-casteaching-layout>
    <div class="flex flex-col">
        @can('series_manage_create')

            <x-status></x-status>

            <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div>
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                            {{$serie->title}}
                        </h3>
                        <form data-qa="form_user_edit" action="#" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 min-w-0">
                                <label for="name"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Titol</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input required type="text" name="title" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2" value="{{$serie->title}}">
                                </div>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="email"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Descripció</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea required id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" >{{$serie->description}}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Save
                            </button>
                        </form>
                    </div>
                </div>

            <x-jet-section-border />

            <x-jet-form-section data-qa="form_serie_image_edit" action="/manage/series/{{$serie->id}}/image" enctype="multipart/form-data">
                <x-slot name="title">
                    {{ __('Miniatura de la serie') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Secció per modificar la imatge de una serie') }}
                </x-slot>

                <x-slot name="form">
                    @csrf
                    @method('PUT')
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="image" value="{{ __('Miniatura') }}"/>
                        <div x-data="{imageName: null, imagePreview: null}" class="col-span-6 sm:col-span-4">

                            <input
                                type="file"
                                class="hidden"
                                name="image"
                                x-ref="image"
                                x-on:change="
                                imageName = $refs.image.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    imagePreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.image.files[0]);
                            " >

                            @if ($serie->image )
                                <div class="mt-2" x-show="! imagePreview">
                                    <img class="h-48 w-full object-cover" src="/storage/{{$serie->image}}" alt="">
                                </div>
                            @endif


                            <div class="mt-2" x-show="imagePreview">
                                <span class="block h-48 bg-cover bg-no-repeat bg-center"
                                    x-bind:style="'background-image: url(\'' + imagePreview + '\');'">
                                </span>
                            </div>

                            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.image.click()">
                                {{ __('Escolliu una imatge') }}
                            </x-jet-secondary-button>

                            @if ($serie->image )
                                <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                                    {{ __('Eliminar') }}
                                </x-jet-secondary-button>
                            @endif

                            <x-jet-input-error for="image" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-button>
                        {{ __('Modificar') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
            </div>

        @endcan

    </div>
</x-casteaching-layout>
