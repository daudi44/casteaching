<x-casteaching-layout>

    <div class="flex flex-col" id="app">
        <div class="flex flex-col mt-10">

            <div class="mx-auto sm:px-6 lg:px-8 w-full max-w-7xl">
                <status></status>

                <div id="app">
                    @can('videos_manage_create')
                        <video-form></video-form>
                    @endcan

                    <videos-list></videos-list>
                </div>
            </div>
        </div>
    </div>
</x-casteaching-layout>
