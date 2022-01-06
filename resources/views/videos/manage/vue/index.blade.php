<x-casteaching-layout>

    <div class="flex flex-col">

        <x-estat></x-estat>

        @can('videos_manage_create')
                <video-form></video-form>
        @endcan

        <videos-list></videos-list>

    </div>
</x-casteaching-layout>
