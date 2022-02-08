import VideosList from "./components/VideosList";
import Alpine from 'alpinejs';
import casteaching from '@acacha/casteaching'
import Vue from 'vue'
import VideoForm from "./components/VideoForm";
import Status from "./components/Status";

require('./bootstrap');

window.Alpine = Alpine;
window.casteaching = casteaching({baseUrl:'/api'});
window.Vue = Vue

const vueApp = document.querySelector('#app')

if (vueApp){
    window.Vue.component('videos-list', VideosList )
    window.Vue.component('video-form', VideoForm )
    window.Vue.component('status', Status )

    const app = new window.Vue({
        el: '#app',
    });
}

Alpine.start();


