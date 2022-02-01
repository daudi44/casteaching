import Alpine from 'alpinejs';
import Vue from 'vue';
import VideosList from "./components/VideosList";
import VideoForm from "./components/VideoForm";
import VideoEstat from "./components/VideoEstat";
import casteaching from 'casteaching';

require('./bootstrap');

window.Alpine = Alpine;
Alpine.start();
window.casteaching = casteaching;

const vueApp = document.querySelector('#app')

if(vueApp){
    window.Vue = Vue
    window.Vue.component('videos-list', VideosList )
    window.Vue.component('video-form', VideoForm )
    window.Vue.component('status', Status )

    const app = new window.Vue({
        el: '#app',
    });
}
