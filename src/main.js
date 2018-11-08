import Vue from 'vue'
import BlogCreator from './components/BlogCreator.vue'
// import BCYoutubeField from './components/BCYoutubeField'

// window._ = require('lodash');
// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = true

Vue.component('blog-creator', BlogCreator);

// &#8202;—&#8202;

new Vue({
    el: '#app'
});