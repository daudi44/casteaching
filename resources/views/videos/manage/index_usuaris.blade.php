<x-casteaching-layout>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="flex flex-col">
        <x-estat></x-estat>
            @can('users_manage_create')
                <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                        <div class="ml-4 mt-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                                Afegir Usuaris
                            </h3>
                            <form data-qa="form_video_add" action="#" method="POST">
                                @csrf
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 min-w-0">
                                    <label for="name"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Name</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="text" name="name" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="email"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Email</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="text" name="email" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6">
                                    <label for="password"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Password</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="password" name="password" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <button type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

        <div class="overflow-x-auto">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow border-b border-gray-200 sm:rounded-lg">
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 mt-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Usuaris - Dani
                        </h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">

                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @if($loop->odd)
                                <tr class="bg-white">
                            @else
                                <tr class="bg-gray-200">
                                    @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->name}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$user->email}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/manage/users/{{$user->id}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form class="inline" method="POST" action="/manage/users/{{$user->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/manage/users" class="text-indigo-600 hover:text-indigo-900" onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    </div>
</x-casteaching-layout>
