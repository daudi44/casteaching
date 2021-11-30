<x-casteaching-layout>
    <div class="flex flex-col">

        @can('videos_manage_create')


            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 sm:-mr-4">
                <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap sm:-mr-4">
                    <div class="ml-4 mt-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                            Afegir Videos
                        </h3>
                            <form data-qa="form_video_add" action="" method="POST">
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="title"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Title</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text" name="title" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <textarea name="description" id="description" cols="30" rows="1"  class="mt-1 sm:mt-0 sm:col-span-2 my-2"></textarea>
                                    </div>
                                </div>

                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                    <label for="url" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Url</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <input type="text" name="url" id="url" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md my-2">
                                    </div>
                                </div>
                                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        @endcan

        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->id}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->title}}</td>
                                {{--                    <td>{{$video->description}}</td>--}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$video->url}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/videos/{{$video->id}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Show</a>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Delete</a>
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
