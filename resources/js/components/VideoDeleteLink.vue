<template>
        <a class="text-indigo-600 hover:text-indigo-900"
        @click="destroy()">Delete</a>
</template>

<script>
import bus from "../bus";

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
            try{
                await window.casteaching.video.destroy(this.video.id)
                this.$emit('removed')
                bus.$emit('status', 'Successfully Deleted')
            }catch (e) {
                console.log(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
