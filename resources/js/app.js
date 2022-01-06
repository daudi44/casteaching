import Alpine from 'alpinejs';
import casteachingdani from 'casteachingdani';
import Vue from 'vue';
import VideosList from "./components/VideosList";
import VideoForm from "./components/VideoForm";

require('./bootstrap');

window.Alpine = Alpine;
window.casteaching = casteachingdani;
window.Vue = Vue;

window.Vue.component('videos-list', VideosList)
window.Vue.component('video-form', VideoForm)

Alpine.start();

const app = new window.Vue({
    el:'#app'
});
