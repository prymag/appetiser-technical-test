import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Home from './Home';

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/test',
        component: Home
    }
]

export default new VueRouter({ mode: 'history', routes: routes })