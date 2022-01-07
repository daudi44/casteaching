<x-casteaching-layout>

    <div class="flex flex-col">
        <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <video-estat></video-estat>
        </div>


        @can('videos_manage_create')
                <video-form></video-form>
        @endcan

        <videos-list></videos-list>

    </div>
</x-casteaching-layout>
