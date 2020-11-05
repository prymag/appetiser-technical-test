require('./bootstrap');

window.Vue = require('vue');

import App from "./vue/App";
import router from './vue/router';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});