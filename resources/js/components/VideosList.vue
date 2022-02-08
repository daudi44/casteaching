<template>
    <div class="overflow-x-auto">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow border-b border-gray-200 sm:rounded-lg">
                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 mt-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Videos - Dani
                        <button @click="refresh" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Refresh
                        </button>
                    </h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">

                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($videos as $video)
                    @if($loop->odd)
                    <tr class="bg-white">
                        @else
                    <tr class="bg-gray-200">
                        @endif-->
                    <tr class="bg-white" v-for="video in videos">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{video.id}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{video.title}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{video.url}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <video-show-link :video="video"></video-show-link>
                            <video-edit-link :video="video"></video-edit-link>
                            <video-destroy-link :video="video" @removed="refresh()" ></video-destroy-link>
                        </td>
                    </tr>
                    <!--@endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import VideoShowLink from "./VideoShowLink";
import VideoEditLink from "./VideoEditLink";
import bus from '../bus'
import VideoDestroyLink from "./VideoDestroyLink";

export default {
    name: "VideosList",
    components:{
        'video-show-link':VideoShowLink,
        'video-edit-link':VideoEditLink,
        'video-destroy-link':VideoDestroyLink
    },
    data(){
        return {
            videos: []
        }
    },
    async created() {
        this.getVideos()
        bus.$on('created', ()=>{
            this.refresh()
        })
    },
    methods:{
        async getVideos(){
            this.videos = await window.casteaching.videos()
        },
        async refresh (){
            this.getVideos()
        }
    }
}
</script>

<style scoped>

</style>
