<template>
        <a class="text-indigo-600 hover:text-indigo-900"
        @click="destroy()">Delete</a>
</template>

<script>
export default {
    name: "VideoDeleteLink",
    props: {
        video: {
            type: Object,
            required: true
        }
    },
    methods: {
        async destroy(){
             await window.casteaching.video.destroy(this.video.id)
        }
    }
}
</script>

<style scoped>

</style>
