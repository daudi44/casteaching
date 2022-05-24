<x-casteaching-layout>
    <div class="flex flex-col">
        @can('users_manage_create')
                <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                            {{$user->name}}
                        </h3>
                            <form data-qa="form_user_edit" action="#" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 min-w-0">
                                    <label for="name"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Nom</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="text" name="name" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="email"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">E-mail</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="text" name="email" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2" value="{{$user->email}}">
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6">
                                    <label for="password"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Contrasenya</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="password" name="password" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <button type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Modificar
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</x-casteaching-layout>
