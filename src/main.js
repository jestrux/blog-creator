import Vue from 'vue'
import BlogCreator from './components/BlogCreator.vue'
// import BcImageField from './components/BCImageField.vue'

// window._ = require('lodash');
// window.axios = require('axios');

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = true

Vue.component('blog-creator', BlogCreator);

new Vue({
    el: '#app'
});