<x-casteaching-layout>

    <div class="flex flex-col">

        <x-status></x-status>

        @can('videos_manage_create')
                <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                            Afegir Videos
                        </h3>
                            <form data-qa="form_video_add" action="#" method="POST">
                                @csrf
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 min-w-0">
                                    <label for="title"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Title</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input required type="text" name="title" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea name="description" id="description" cols="30" rows="1"  class="mt-1 sm:mt-0 sm:col-span-2 my-2"></textarea>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6">
                                    <label for="url" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Url</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="max-w-lg flex rounded-md shadow-sm">
                                              <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm ">
                                                https://
                                              </span>
                                                <input type="url" name="url" id="url" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">

                                        </div>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6"">
                                    <div class="col-span-3">
                                        <label for="serie" class="block text-sm font-medium text-gray-700">
                                            Serie
                                        </label>
                                        <select id="serie" name="serie_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">-- Escolliu una serie --</option>
                                            @foreach (App\Models\Serie::all() as $serie)
                                                <option value="{{ $serie->id }}"> {{ $serie->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6"">
                                    <div class="col-span-3">
                                        <label for="user" class="block text-sm font-medium text-gray-700">
                                            User
                                        </label>
                                        <select id="user" name="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">-- Escolliu un usuari --</option>
                                            @foreach (App\Models\User::all() as $user)
                                                <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                            @endforeach
                                        </select>
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
                            Videos - Dani
                        </h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">

                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            {{--                <th>Description</th>--}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($videos as $video)
                            @if($loop->odd)
                                <tr class="bg-white">
                            @else
                                <tr class="bg-gray-200">
                            @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->title}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->url}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/videos/{{$video->id}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Show</a>
                                    <a href="/manage/videos/{{$video->id}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form class="inline" method="POST" action="/manage/videos/{{$video->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/videos/{{$video->id}}" class="text-indigo-600 hover:text-indigo-900" onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
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
