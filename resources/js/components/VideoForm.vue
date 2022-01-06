<template>
    <div class="mx-auto w-full max-w-6xl bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
        <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 pb-3">
                    Afegir Videos
                </h3>
                <form data-qa="form_video_add" @submit.prevent="store">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 min-w-0">
                        <label for="title"  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Title</label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input required type="text" name="title" v-model="video.title" id="title" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md my-2">
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description</label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <textarea name="description" id="description" cols="30" rows="1" v-model="video.description" class="mt-1 sm:mt-0 sm:col-span-2 my-2"></textarea>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 pb-6">
                        <label for="url" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Url</label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                              <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm ">
                                                https://
                                              </span>
                                <input type="url" name="url" id="url" v-model="video.url" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">

                            </div>
                        </div>
                    </div>
                    <button @click="store" type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "VideoForm",
    data(){
        return {
            video: {}
        }
    },
    methods:{
        store(){
            window.casteaching.video.create({
                title: this.video.title,
                url: this.video.url,
                description: this.video.description,

            })
        }
    }
}
</script>

<style scoped>

</style>
